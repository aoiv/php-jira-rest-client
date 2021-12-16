<?php
include "../vendor/autoload.php";

use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Project\Project;
use JiraRestApi\Component\ComponentService;
use JiraRestApi\Component\Component;

echo str_repeat("-", 50) . "\n";
try {
    $componentService = new ComponentService();
    $projectService = new ProjectService();

    $project = $projectService->get('PANDA_SERVER');
    $comps = $projectService->getComponents('PANDA_SERVER_ASSOAU');

    foreach ($comps as $component) {
        echo "--" . $component->getName() . PHP_EOL;
        if ($component instanceof Component) {
            $component->setProjectKey($project->key);
            try {
                $res = $componentService->create($component);
                echo "Создано!" . PHP_EOL;
            } catch (JiraRestApi\JiraException $e) {
                print("Error Occured! " . $e->getMessage() . PHP_EOL);
            }
        }
    }
} catch (JiraRestApi\JiraException $e) {
    print("Error Occured! " . $e->getMessage() . PHP_EOL);
}