<div>
    <p>Hello {{ $projectManager['name'] }},</p>
    <p>We found some projects where the expected hours are zero for you or team members where you are assigned as project manager. Please update these projects:</p>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Project Name</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($projectManager['projects'] as $project)
            <tr>
                <td>
                  <li>{{ $project->name }}</li>
                </td>
            </tr>
             @endforeach
        </tbody>
      </table>
    <br>
    <p style="line-height: 1px;">Thanks,</p>
    <p style="line-height: 1px;">Portal Team</p>
    <p style="line-height: 1px;">ColoredCow</p>
</div>
