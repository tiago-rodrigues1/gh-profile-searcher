<?php
    $username = "";

    if (isset($_GET["username"])) {
        $username = htmlspecialchars($_GET["username"]);
    }

    function getUserRespositories(string $resource_url){
        $urlParams = "?sort=created&direction=desc&type=public";
        $urlToFetch = $resource_url."/repos".$urlParams;

        $ch = curl_init();

        try {
            curl_setopt($ch, CURLOPT_URL, $urlToFetch);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-agent:tiago-rodrigues1"));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $data = json_decode($response, true);

            $newestRepos = [];

            if($httpCode == 200) {
                for ($i = 0; $i <= 3; $i++) {
                    $newestRepos[$i] = $data[$i]["name"];
                }
            } else {
                throw new Exception("Não foi possível obter os repositórios deste usuário");
            }

            return $newestRepos;
        } catch (Exception $e) {
            return null;
        } finally {
            curl_close($ch);
        }
    }

    function getUserInfo(string $username) {
        $baseUrl = "https://api.github.com/users/";
        $urlToFetch = $baseUrl.$username;

        $ch = curl_init();

        try {
            curl_setopt($ch, CURLOPT_URL, $urlToFetch);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-agent:tiago-rodrigues1"));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $data = json_decode($response, true);

            $userInfo = [];

            if($httpCode == 200) {
                $userInfo["username"] = $username;
                $userInfo["name"] = $data["name"];
                $userInfo["avatar_url"] = $data["avatar_url"];
                $userInfo["count_followers"] = $data["followers"];
                $userInfo["count_repos"] = $data["public_repos"];
                $userInfo["newest_repos"] = getUserRespositories($urlToFetch);
            } else {
                throw new Exception("Não foi possível obter os dados deste usuário");
            }

            return $userInfo;
        } catch (Exception $e) {
            return null;
        } finally {
            curl_close($ch);
        }        
    }

    $userInfo = getUserInfo($username);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gh-profile | <?php echo $userInfo["username"]?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            list-style: none;
        }

        html,
        body {
            height: 100vh;
            width: 100vw;
        }

        body {
            display: grid;
            place-items: center;
        }

        img {
            width: 9rem;
            height: 9rem;
        }

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
                    </ul>
                </div>
            </main>
            <footer class="w-100 py-2 text-center">
                <a 
                    href=<?php echo "https://github.com/".$userInfo["username"]?>
                    class="btn btn-primary w-100"
                >
                    Visitar perfil
                </a>
            </footer>
        </article>
    <?php else: ?>
        <h1>Não foi possível realizar esta busca</h1>
    <?php endif ?>
</body>
</html>