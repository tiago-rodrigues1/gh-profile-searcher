<?php
    $username = "";
    $userInfo = [];

    if (isset($_GET["username"])) {
        $username = htmlspecialchars($_GET["username"]);
    }

    function getUserRespositories(string $resource_url){
        $urlParams = "?sort=created&direction=desc&type=public";
        $urlToFetch = $resource_url."/repos".$urlParams;

        $ch = curl_init();
        $response = "";

        try {
            curl_setopt($ch, CURLOPT_URL, $urlToFetch);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-agent:tiago-rodrigues1"));

            $response = curl_exec($ch);
            $data = json_decode($response, true);
        } catch (Exception $e) {
            $response = "Não foi possível buscar este usuário";
        } finally {
            curl_close($ch);
        }

        $newestRepos = [];

        for ($i = 0; $i <= 3; $i++) {
            $newestRepos[$i] = $data[$i]["name"];
        }

        return $newestRepos;
    }

    function getUserInfo(string $username) {
        global $userInfo;

        $baseUrl = "https://api.github.com/users/";
        $urlToFetch = $baseUrl.$username;

        $ch = curl_init();
        $response = "";

        try {
            curl_setopt($ch, CURLOPT_URL, $urlToFetch);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-agent:tiago-rodrigues1"));

            $response = curl_exec($ch);
            $data = json_decode($response, true);
        } catch (Exception $e) {
            $response = "Não foi possível buscar este usuário";
        } finally {
            curl_close($ch);
        }

        $userInfo["username"] = $username;
        $userInfo["name"] = $data["name"];
        $userInfo["avatar_url"] = $data["avatar_url"];
        $userInfo["count_followers"] = $data["followers"];
        $userInfo["count_repos"] = $data["public_repos"];
        $userInfo["newest_repos"] = implode(" | ", getUserRespositories($urlToFetch));
    }

    getUserInfo($username);

    foreach ($userInfo as $key => $value) {
        echo "$key => $value <br>";
    }
?>