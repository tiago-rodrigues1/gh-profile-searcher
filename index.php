<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Github Profile</title>

    <script src="public/scripts/script.js" defer></script>
    <link rel="stylesheet" href="public/styles/style.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <style>
        @media screen and (max-width: 640px) {
            #submitbtn {
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-dark text-light">
    <header class="w-100 border-bottom border-secondary border-opacity-50 vstack gap-2 p-4">
        <h1 class="fw-bold fs-1">&lt;/GitHolmes&gt;</h1>
        <h3 class="fw-normal fs-6">Github profile searcher</h3>
    </header>
    <main class="container-sm">
        <form method="get" action="getUserInfo.php" class="w-100 d-flex flex-wrap gap-4 py-4">
            <div class="vstack">
                <label for="username" class="form-label">Github Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="form-control"
                    placeholder="github profile username"
                    require
                >
            </div>
            <button 
                type="submit" 
                class="btn btn-primary align-self-end"
                id="submitbtn"
                style="height:2.375rem;"
            >
                <div class="d-flex gap-2 align-items-center justify-content-center">
                    <span>Buscar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
            </button>
        </form>
    </main>
</body>
</html>