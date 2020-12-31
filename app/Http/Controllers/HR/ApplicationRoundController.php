<?php

namespace App\Http\Controllers\HR;

use App\Helpers\ContentHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicantRoundMailRequest;
use App\Http\Requests\HR\ApplicationRoundRequest;
use App\Mail\HR\Applicant\RoundReviewed;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Helpers\TemplateHelper;

class ApplicationRoundController extends Controller
{
    /**
     * Update the specified resource in storage.
     * @param  ApplicationRoundRequest $request
     * @param  ApplicationRound        $round
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRoundRequest $request, ApplicationRound $round)
    {
        $round->_update($request->validated());
        if (array_key_exists('round_evaluation', $request->validated())) {
            $round->updateOrCreateEvaluation($request->validated()['round_evaluation']);
        }

        $routeName = $round->application->job->type == 'internship' ? 'applications.internship.index' : 'applications.job.index';
        return redirect()->route($routeName)->with('status', 'Application updated successfully!');
    }

    /**
     * Send email to the applicant for current round
     *
     * @param  ApplicantRoundMailRequest $request
     * @param  ApplicationRound            $applicationRound
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMail(ApplicantRoundMailRequest $request, ApplicationRound $applicationRound)
    {
        $validated = $request->validated();
        $applicant = $applicationRound->application->applicant;
        $job = $applicationRound->application->job;

        $mail_body = ContentHelper::editorFormat($validated['mail_body']);
        $mail_body = str_replace(config('constants.hr.template-variables.applicant-name'), $applicant->name, $mail_body);
        $mail_body = str_replace(config('constants.hr.template-variables.job-title'), $job->title, $mail_body);

        $applicationRound->load('application', 'application.job', 'application.applicant');
        $applicationRound->update([
            'mail_sent' => true,
            'mail_subject' => $validated['mail_subject'],
            'mail_body' => $mail_body,
            'mail_sender' => Auth::id(),
            'mail_sent_at' => Carbon::now(),
        ]);

        Mail::send(new RoundReviewed($applicationRound));

        return redirect()->back()->with(
            'status',
            "Mail sent successfully to the <b>$applicant->name</b> at <b>$applicant->email</b>.<br>
            <span data-toggle='modal' data-target='#round_mail_$applicationRound->id' class='modal-toggler-text text-primary'>Click here to see the mail content.</a>"
        );
    }

    public function getMailContent(ApplicationRound $applicationRound, string $status)
    {
        $applicationRound->load('round', 'application', 'application.applicant', 'application.job');
        $application = $applicationRound->application;
        $templateType = $status == 'confirm' ? 'confirmed_mail_template' : 'rejected_mail_template';
        $template = $applicationRound->round->{$templateType};
        return [
            'subject' => $template['subject'] ?? '',
            'body' => isset($template['body']) ? TemplateHelper::parse($template['body'], [
                'interview_slot_link' => "<a href='" . $application->getScheduleInterviewLink() . "'>Schedule interview</a>",
                'applicant_name' => $application->applicant->name,
                'job_title' => $application->job->title,
                'interview_time' => $applicationRound->scheduled_date ? $applicationRound->scheduled_date->format(config('constants.display_time_format')) : '',
            ]) : '',
        ];
    }

    public function storeFollowUp(Request $request, ApplicationRound $applicationRound)
    {
        $applicationRound->followUps()->create([
            'comments' => $request->get('comments'),
            'conducted_by' => auth()->id(),
        ]);
        return redirect()->back()->with('status', 'Follow up successful!');
    }
}
