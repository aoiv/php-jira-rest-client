<?php
include "../vendor/autoload.php";

use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;
use JiraRestApi\Project\Project;
use JiraRestApi\Issue\Version;
use JiraRestApi\Version\VersionService;

echo str_repeat("-", 50) . "\n";

try {
    $projectService = new ProjectService();
    $versionService = new VersionService();

    $vers = $projectService->getVersions('PANDA_SERVER');

    foreach ($vers as $version) {
        print_r($version);
        if ($version instanceof Version) {
            $version->setReleased(true);
            try {
                $res = $versionService->update($version);
                echo "Обновлено!\n";
            } catch (JiraRestApi\JiraException $e) {
                print("Error Occured! " . $e->getMessage() . "\n");
            }

        }
    }
} catch (JiraRestApi\JiraException $e) {
    print("Error Occured! " . $e->getMessage());
}