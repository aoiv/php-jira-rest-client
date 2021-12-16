<?php
include "../vendor/autoload.php";

use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Project\Project;
use JiraRestApi\Issue\Version;
use JiraRestApi\Issue\Component;
use JiraRestApi\Version\VersionService;

echo str_repeat("-", 50) . "\n";
try {
    $projectService = new ProjectService();
    $project = $projectService->get('PANDA_SERVER');

    $versionService = new VersionService();

    $vers = $projectService->getVersions('PANDA_SERVER_ASSOAU');

    foreach ($vers as $version) {
        print_r($version);
        if ($version instanceof Version) {
            $version->setProjectId($project->id);
            $version->setReleased(true);
            if ($version->releaseDate && $version->userReleaseDate) {
                unset($version->userReleaseDate);
            }
            try {
                $res = $versionService->create($version);

                echo "Создано!\n";
            } catch (JiraRestApi\JiraException $e) {
                print("Error Occured! " . $e->getMessage() . "\n");
            }

        }
    }
} catch (JiraRestApi\JiraException $e) {
    print("Error Occured! " . $e->getMessage());
}