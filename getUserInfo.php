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

        .grid-repos {
            display: grid;
            grid-template-columns: auto auto;
            column-gap: 1.5rem;
            row-gap: 1rem;
        }
    </style>
</head>
<body class="bg-dark text-light">
    <?php if ((bool)$userInfo): ?>
        <article class="p-4 rounded-4 bg-secondary bg-opacity-25">
            <header class="vstack gap-2 pb-4">
                <h1 class="fw-medium fs-2"><?php echo $userInfo["name"]?></h1>
                <h3 class="fw-normal fs-6 opacity-75"><?php echo $userInfo["username"]?></h3>
            </header>
            <main>
                <div class="w-100 text-center py-2">
                    <img 
                        src=<?php echo $userInfo["avatar_url"]?> 
                        alt="Foto de <?php echo $userInfo["name"]?>"
                        class="rounded-circle mx-auto"
                    >
                </div>
                <div class="w-100 hstack justify-content-between py-2">
                    <p>Seguidores: <strong><?php echo $userInfo["count_followers"]?></strong></p>
                    <p>Repositórios: <strong><?php echo $userInfo["count_repos"]?></strong></p>
                </div>
                <div class="vstack gap-2 py-2">
                    <h2 class="fw-medium fs-5">Repositórios mais recentes</h2>
                    <ul class="px-0 grid-repos">
                        <?php
                            foreach($userInfo["newest_repos"] as $repo) {
                                echo "<li>$repo</li>";
                            }
                        ?>
