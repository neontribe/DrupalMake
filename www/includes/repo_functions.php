<?php
include(__DIR__ . '/config.php');

// Functions
// Fetches list of all repos on Neontribes github
function fetchRepos() {
    $allrepos = array();
    $page = 1;

    do {
        $ch = curl_init();
        $url = sprintf("https://api.github.com/orgs/neontribe/repos?page=%d&type=all&access_token=%s", $page, OAUTH_TOKEN);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $json = curl_exec($ch);
        $json_decoded = json_decode($json, true);

        if (count($json_decoded) > 0) {
            $allrepos = array_merge($allrepos, $json_decoded);
            $page++;
        }

        curl_close($ch);
    } while (count($json_decoded) > 0);

    return $allrepos;
}

// Check if info file exists in all repos. If .info file is present, return true, if .info file isn't present return false
function infoFile($name) {
    $ch = curl_init();
    $url = sprintf("https://api.github.com/repos/neontribe/%s/contents/?access_token=%s&ref=master", $name, OAUTH_TOKEN);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $infojson = curl_exec($ch);
    $infojson_decoded = json_decode($infojson, true);
    curl_close($ch);

    $files = count($infojson_decoded);
    $exists_array = array();

    for ($i = 0; $i < $files; $i++) {
        if (endsWith($infojson_decoded[$i]['name'], '.info')) {
            $info_file = $infojson_decoded[$i]['name'];
            $exists_array[$i] = $info_file;
        }
    }

    if (empty($exists_array)) {
        return false;
    } else {
        return true;
    }
}

// Fetches all the branches for each repository selected
function fetchBranches($repo) {
    $allbranches = array();
    $page = 1;

    do {
        $ch = curl_init();
        $url = sprintf("https://api.github.com/repos/neontribe/%s/branches?page=%d&access_token=%s", $repo, $page, OAUTH_TOKEN);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $json = curl_exec($ch);
        $json_decoded = json_decode($json, true);

        if (count($json_decoded) > 0) {
            $allbranches = array_merge($allbranches, $json_decoded);
            $page++;
        }

        curl_close($ch);
    } while (count($json_decoded) > 0);

    return $allbranches;
}

// Check if a string ends with a given string
function endsWith($str, $sub) {
    return (substr($str, strlen($str) - strlen($sub)) === $sub);
}

function repos ($update = false)
{
    $currentSeconds = time();
    if ((!(apc_exists('LAST_REPO_CHECK') && ($currentSeconds - apc_fetch('LAST_REPO_CHECK')) < (60 * 60))) || $update == "true") {
        // This loops through each repo and gets it name and adds it to an array if based on the output of the infoFile function
        $json_decoded = fetchRepos();
        for ($i = 0; $i < count($json_decoded); $i++) {
            $name = $json_decoded[$i]['name'];
            $name_exists = infoFile($name);

            if ($name_exists == false) {
            } else {
                $branch[] = $name;
            }
        }

        // Put repo name in array as $array[name][name]
        //$repos[$repo] = $branch;
        $repos = $branch;

        apc_store('LAST_REPO_CHECK', $currentSeconds);
        apc_store('REPOS', $repos);
    }
    
    return apc_fetch('REPOS');
}
?>