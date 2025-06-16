<?php
use PHPUnit\Framework\TestCase;

class ProjectDurationTest extends TestCase
{
    public function testFinishedProjectShowsDays()
    {
        $row = [
            'project_status'   => 'finished',
            'established_date' => '2024-01-01 00:00:00',
            'finished_date'    => '2024-01-10 00:00:00'
        ];

        $result = ProjectDuration(1, $row);
        $this->assertMatchesRegularExpression('/\d+\s+day/', $result);
    }

    public function testIncompleteProjectReturnsDuration()
    {
        $row = [
            'project_status'   => 'active',
            'established_date' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'finished_date'    => null
        ];

        $result = ProjectDuration(1, $row);
        $this->assertNotEmpty($result);
    }
}
