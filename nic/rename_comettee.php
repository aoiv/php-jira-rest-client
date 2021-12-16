<?php
include "../vendor/autoload.php";

use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Project\Project;
use JiraRestApi\Component\ComponentService;
use JiraRestApi\Component\Component;

echo str_repeat("-", 50) . "\n";
try {
    $projectService = new ProjectService();
    $componentService = new ComponentService();
    $projects = $projectService->getAllProjects();

    foreach ($projects as $project) {
        echo "-- " . $project->key . PHP_EOL;
        $comps = $projectService->getComponents($project->key);
        if (!empty($comps)) {
            foreach ($comps as $component) {
                $component_name = $component->getName();
                echo "----" . $component->getName() . PHP_EOL;
                if ($component_name == 'project-committee') {
                    $component->setDescription('Задачи проектного комитета');
                    try {
                        $res = $componentService->update($component);
                        echo "Обновлено!\n";
                    } catch (JiraRestApi\JiraException $e) {
                        print("Error Occured! " . $e->getMessage() . "\n");
                    }
                }
            }
        }
    }
} catch (JiraRestApi\JiraException $e) {
    print("Error Occured! " . $e->getMessage());
}
