<?php
require_once '../mysql.php';
session_start();

// Verifica se o token está presente no cookie
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];


    $conn = conectarBancoDados();
    $stmt = $conn->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultados = $stmt->get_result();

    if ($resultados->num_rows > 0) {
        // Verifica se o email do usuário está validado
        $row = $resultados->fetch_assoc();
        $nome = $row['usuario'];
        $email = $row['email'];
        $avaliacao = $row['avalicao'];
       $link_text = $avaliacao ? 'Avaliação já feita' : '<a style="text-decoration:none;color: #1f1c2e;cursor:pointer;" href="https://dhardware.rf.gd/dashboard/atividade">Iniciar</a>';


    } else {
        // Informação não encontrada, redireciona para a página de formulário
        header("Location: https://dhardware.rf.gd/formulario");
        exit();
    }

    $conn->close();
} else {
    // Cookie não encontrado, redireciona para a página de formulário
    header("Location: https://dhardware.rf.gd/formulario");
    exit();
}
?>
<?php
$avaliacao = $row['avalicao'];
$avaliacao_feita = $avaliacao ? 'true' : 'false';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" type="text/css" href="/dashboard/dash.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="app-container">
        <div class="app-header">
            <div class="app-header-left">
                <span class="app-icon"></span>
                <p class="app-name">SociaRate</p>
                <div class="search-wrapper">
                    <input class="search-input" type="text" placeholder="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-search"
                        viewBox="0 0 24 24">
                        <defs></defs>
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                </div>
            </div>
            <div class="app-header-right">

                <button style="opacity:0;" class="add-btn" title="Add New Project">
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-plus">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </button>
                <button style="opacity:0;" class="notification-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                </button>
                <button  title="Dark Mode" onclick="dark_user()" class="mode-switch" title="Switch Theme">
                    <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" width="30px" height="30px" viewBox="0 0 24 24">
                        <defs></defs>
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                    </svg>
                </button>
                <button class="profile-btn">
                    <div class="avatar">
                        <svg id="avatar" fill="#000000" width="33px" height="33px" viewBox="0 0 32 32" id="icon"
                            xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                    }
                                </style>
                            </defs>
                            <path id="_inner-path_" data-name="&lt;inner-path&gt;" class="cls-1"
                                d="M8.0071,24.93A4.9958,4.9958,0,0,1,13,20h6a4.9959,4.9959,0,0,1,4.9929,4.93,11.94,11.94,0,0,1-15.9858,0ZM20.5,12.5A4.5,4.5,0,1,1,16,8,4.5,4.5,0,0,1,20.5,12.5Z" />
                            <path
                                d="M26.7489,24.93A13.9893,13.9893,0,1,0,2,16a13.899,13.899,0,0,0,3.2511,8.93l-.02.0166c.07.0845.15.1567.2222.2392.09.1036.1864.2.28.3008.28.3033.5674.5952.87.87.0915.0831.1864.1612.28.2417.32.2759.6484.5372.99.7813.0441.0312.0832.0693.1276.1006v-.0127a13.9011,13.9011,0,0,0,16,0V27.48c.0444-.0313.0835-.0694.1276-.1006.3412-.2441.67-.5054.99-.7813.0936-.08.1885-.1586.28-.2417.3025-.2749.59-.5668.87-.87.0933-.1006.1894-.1972.28-.3008.0719-.0825.1522-.1547.2222-.2392ZM16,8a4.5,4.5,0,1,1-4.5,4.5A4.5,4.5,0,0,1,16,8ZM8.0071,24.93A4.9957,4.9957,0,0,1,13,20h6a4.9958,4.9958,0,0,1,4.9929,4.93,11.94,11.94,0,0,1-15.9858,0Z" />
                            <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1"
                                width="32" height="32" />
                        </svg>
                    </div>
                    <span  title="Meu Nome De Usuario" id='nome'><span style=" padding:5px;" id="nome">
                            <?php echo $nome ?>
                        </span></span>
                </button>
            <a style="margin-left:1em;" onclick="logout()" title="Clique aqui para sair" id="logout" class="logout">
                <svg id="avatar" fill="#000000" height="30px" width="30px" version="1.1" id="Capa_1"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490.3 490.3"
                    xml:space="preserve">
                    <g>
                        <g>
                            <path d="M0,121.05v248.2c0,34.2,27.9,62.1,62.1,62.1h200.6c34.2,0,62.1-27.9,62.1-62.1v-40.2c0-6.8-5.5-12.3-12.3-12.3
            s-12.3,5.5-12.3,12.3v40.2c0,20.7-16.9,37.6-37.6,37.6H62.1c-20.7,0-37.6-16.9-37.6-37.6v-248.2c0-20.7,16.9-37.6,37.6-37.6h200.6
            c20.7,0,37.6,16.9,37.6,37.6v40.2c0,6.8,5.5,12.3,12.3,12.3s12.3-5.5,12.3-12.3v-40.2c0-34.2-27.9-62.1-62.1-62.1H62.1
            C27.9,58.95,0,86.75,0,121.05z" />
                            <path d="M385.4,337.65c2.4,2.4,5.5,3.6,8.7,3.6s6.3-1.2,8.7-3.6l83.9-83.9c4.8-4.8,4.8-12.5,0-17.3l-83.9-83.9
            c-4.8-4.8-12.5-4.8-17.3,0s-4.8,12.5,0,17.3l63,63H218.6c-6.8,0-12.3,5.5-12.3,12.3c0,6.8,5.5,12.3,12.3,12.3h229.8l-63,63
            C380.6,325.15,380.6,332.95,385.4,337.65z" />
                        </g>
                    </g>
                </svg></a>
                <script>
                    function logout() {
                        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/dashboard;";
                        window.location.href = "https://dhardware.rf.gd/formulario";
                    }
                </script>

            </div>
        </div>
        <div class="app-content">
            <div class="app-sidebar">
                <a href="" class="app-sidebar-link active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </a>
                <a href="" class="app-sidebar-link" style="opacity: 0;">
                    <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="feather feather-pie-chart" viewBox="0 0 24 24">
                        <defs />
                        <path d="M21.21 15.89A10 10 0 118 2.83M22 12A10 10 0 0012 2v10z" />
                    </svg>
                </a>
                <a href="" class="app-sidebar-link" style="opacity: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-calendar">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </a>
                <a href="" class="app-sidebar-link" style="opacity: 0;">
                    <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="feather feather-settings" viewBox="0 0 24 24">
                        <defs />
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
                    </svg>
                </a>
            </div>
            <div class="projects-section">
                <div class="projects-section-header">
                    <p>Projects</p>
                    <p id="time" class="time">December, 12</p>
                </div>
                <div class="projects-section-line">
                    <div class="projects-status">
                        <div class="item-status">
                            <span id="fazer" class="status-number" style="font-stize:15pt";>45</span>
                            <span class="status-type" style="font-stize:15pt";>Disponivel</span>
                        </div>
                        <div class="item-status">
                            <span id="feito" class="status-number" style="font-stize:15pt";>24</span>
                            <span class="status-type" style="font-stize:15pt";>Realizadas</span>
                        </div>
                    </div>
                    <div class="view-actions">
                        <button class="view-btn list-view" title="List View">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-list">
                                <line x1="8" y1="6" x2="21" y2="6" />
                                <line x1="8" y1="12" x2="21" y2="12" />
                                <line x1="8" y1="18" x2="21" y2="18" />
                                <line x1="3" y1="6" x2="3.01" y2="6" />
                                <line x1="3" y1="12" x2="3.01" y2="12" />
                                <line x1="3" y1="18" x2="3.01" y2="18" />
                            </svg>
                        </button>
                        <button class="view-btn grid-view active" title="Grid View">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-grid">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="project-boxes jsGridView">
                    <div class="project-box-wrapper">
                        <div class="project-box" style="background-color: #fee4cb;">
                            <div class="project-box-header">
                                <span id="card-day" style="font-size:12pt;">December 10, 2020</span>
                                <div class="more-wrapper">
                                    <button class="project-btn-more">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-vertical">
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="12" cy="5" r="1" />
                                            <circle cx="12" cy="19" r="1" />
                                        </svg>
                                    </button>
                                </div>
                      </div>
<?php                     
    if ($avaliacao == 0) {
        // Informação presente na página
?>
    <div class="project-box-content-header">
        <p style="font-size:16pt;" class="box-content-header">Avaliação Social</p>
        <p style="font-size:16pt;margin-top:15px;" class="box-content-subheader">Clique Aqui Para Iniciar</p>
    </div>
    <div style="opacity: 0;" class="box-progress-wrapper">
        <p class="box-progress-header">Progress</p>
        <div class="box-progress-bar">
            <span class="box-progress" style="width: 60%; background-color: #ff942e"></span>
        </div>
        <p class="box-progress-percentage">60%</p>
    </div>
    <div class="project-box-footer">
        <div class="days-left" style="text-align:center;font-size:16pt;color: #ff942e;">
            <?php
                $msg = $link_text;
                echo '<p class="some-class">' . $msg . '</p>';
            ?>
                        </div>
                    </div>
                <?php
                    } else {
                        // Usuário não tem acesso à informação
                ?>
                    <div class="project-box-content-header">
                        <p style="font-size:16pt;margin-top:15px;" class="box-content-header">Avaliação Social</p>
                        <p style="font-size:16pt;margin-top:15px;" class="box-content-header">Ja Foi feita</p>
                    </div>
                                <div style="opacity: 0;" class="box-progress-wrapper">
                    <p class="box-progress-header">Progress</p>
                    <div class="box-progress-bar">
                        <span class="box-progress" style="width: 60%; background-color: #ff942e"></span>
                    </div>
                    <p class="box-progress-percentage">60%</p>
                </div>
                    <div class="project-box-footer">
                        <div class="days-left" style="text-align:center;font-size:16pt;cursor:not-allowed;color: #ff942e;">
                            <?php
                                $msg = "Sem acesso";
                                echo '<p class="some-class">' . $msg . '</p>';
                            ?>
                        </div>
                    </div>
                <?php
                    }
                ?>
                    </div>
                    <div class="project-box-wrapper" id="1" style="display: none;">
                        <div class="project-box" style="background-color: #e9e7fd;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper">
                                    <button class="project-btn-more">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-vertical">
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="12" cy="5" r="1" />
                                            <circle cx="12" cy="19" r="1" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="project-box-content-header">
                                <p class="box-content-header">Testing</p>
                                <p class="box-content-subheader">Prototyping</p>
                            </div>
                            <div sty class="box-progress-wrapper">
                                <p class="box-progress-header">Progress</p>
                                <div class="box-progress-bar">
                                    <span class="box-progress" style="width: 50%; background-color: #4f3ff0"></span>
                                </div>
                                <p class="box-progress-percentage">50%</p>
                            </div>
                            <div class="project-box-footer">
                                <div class="participants">
                                    <img src="https://images.unsplash.com/photo-1596815064285-45ed8a9c0463?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1215&q=80"
                                        alt="participant">
                                    <img src="https://images.unsplash.com/photo-1583195764036-6dc248ac07d9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2555&q=80"
                                        alt="participant">
                                    <button class="add-participant" style="color: #4f3ff0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="days-left" style="color: #4f3ff0;">
                                    2 Days Left
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-box-wrapper" id="2" style="display: none;">
                        <div class="project-box">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper">
                                    <button class="project-btn-more">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-vertical">
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="12" cy="5" r="1" />
                                            <circle cx="12" cy="19" r="1" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="project-box-content-header">
                                <p class="box-content-header">Svg Animations</p>
                                <p class="box-content-subheader">Prototyping</p>
                            </div>
                            <div class="box-progress-wrapper">
                                <p class="box-progress-header">Progress</p>
                                <div class="box-progress-bar">
                                    <span class="box-progress" style="width: 80%; background-color: #096c86"></span>
                                </div>
                                <p class="box-progress-percentage">80%</p>
                            </div>
                            <div class="project-box-footer">
                                <div class="participants">
                                    <img src="https://images.unsplash.com/photo-1587628604439-3b9a0aa7a163?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MjR8fHdvbWFufGVufDB8fDB8&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60"
                                        alt="participant">
                                    <img src="https://images.unsplash.com/photo-1596815064285-45ed8a9c0463?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1215&q=80"
                                        alt="participant">
                                    <button class="add-participant" style="color: #096c86;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="days-left" style="color: #096c86;">
                                    2 Days Left
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-box-wrapper" id="3" style="display: none;">
                        <div class="project-box" style="background-color: #ffd3e2;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper">
                                    <button class="project-btn-more">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-vertical">
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="12" cy="5" r="1" />
                                            <circle cx="12" cy="19" r="1" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="project-box-content-header">
                                <p class="box-content-header">UI Development</p>
                                <p class="box-content-subheader">Prototyping</p>
                            </div>
                            <div class="box-progress-wrapper">
                                <p class="box-progress-header">Progress</p>
                                <div class="box-progress-bar">
                                    <span class="box-progress" style="width: 20%; background-color: #df3670"></span>
                                </div>
                                <p class="box-progress-percentage">20%</p>
                            </div>
                            <div class="project-box-footer">
                                <div class="participants">
                                    <img src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2550&q=80"
                                        alt="participant">
                                    <img src="https://images.unsplash.com/photo-1587628604439-3b9a0aa7a163?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MjR8fHdvbWFufGVufDB8fDB8&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60"
                                        alt="participant">
                                    <button class="add-participant" style="color: #df3670;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="days-left" style="color: #df3670;">
                                    2 Days Left
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-box-wrapper" id="4" style="display: none;">
                        <div class="project-box" style="background-color: #c8f7dc;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper">
                                    <button class="project-btn-more">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-vertical">
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="12" cy="5" r="1" />
                                            <circle cx="12" cy="19" r="1" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="project-box-content-header">
                                <p class="box-content-header">Data Analysis</p>
                                <p class="box-content-subheader">Prototyping</p>
                            </div>
                            <div class="box-progress-wrapper">
                                <p class="box-progress-header">Progress</p>
                                <div class="box-progress-bar">
                                    <span class="box-progress" style="width: 60%; background-color: #34c471"></span>
                                </div>
                                <p class="box-progress-percentage">60%</p>
                            </div>
                            <div class="project-box-footer">
                                <div class="participants">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2550&q=80"
                                        alt="participant">
                                    <img src="https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MTB8fG1hbnxlbnwwfHwwfA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60"
                                        alt="participant">
                                    <button class="add-participant" style="color: #34c471;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="days-left" style="color: #34c471;">
                                    2 Days Left
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-box-wrapper" id="5" style="display: none;">
                        <div class="project-box" style="background-color: #d5deff;">
                            <div class="project-box-header">
                                <span>December 10, 2020</span>
                                <div class="more-wrapper">
                                    <button class="project-btn-more">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-vertical">
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="12" cy="5" r="1" />
                                            <circle cx="12" cy="19" r="1" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="project-box-content-header">
                                <p class="box-content-header">Web Designing</p>
                                <p class="box-content-subheader">Prototyping</p>
                            </div>
                            <div class="box-progress-wrapper">
                                <p class="box-progress-header">Progress</p>
                                <div class="box-progress-bar">
                                    <span class="box-progress" style="width: 40%; background-color: #4067f9"></span>
                                </div>
                                <p class="box-progress-percentage">40%</p>
                            </div>
                            <div class="project-box-footer">
                                <div class="participants">
                                    <img src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2550&q=80"
                                        alt="participant">
                                    <img src="https://images.unsplash.com/photo-1583195764036-6dc248ac07d9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2555&q=80"
                                        alt="participant">
                                    <button class="add-participant" style="color: #4067f9;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="days-left" style="color: #4067f9;">
                                    2 Days Left
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/dashboard.js"></script>
<script type="text/javascript"> 
    window.onload = function () {
        const dia = document.getElementById('time');
        const date = new Date();
        const options = {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };
        const formattedDate = date.toLocaleDateString('pt-BR', options);
        dia.innerHTML = formattedDate;
        // array com as atividades
          // Write formatted date in the element with id "card-day"
        const cardDay = document.getElementById('card-day');
        cardDay.innerHTML = formattedDate;
            const atividades = [
            {
                id: 1,
                descricao: 'Atividade 1',
                prioridade: 3,
                concluido: <?php echo $avaliacao_feita  ?>
            }
            ];
    
        // contar atividades restantes
        const restantes = atividades.filter(a => !a.concluido).length;
    
        // exibir o número de atividades restantes na área "fazer"
        const fazer = document.getElementById('fazer');
        fazer.innerHTML = `${restantes}`;
    
        // exibir o número de atividades concluídas na área "feito"
        const feito = document.getElementById('feito');
        feito.innerHTML = `${atividades.length - restantes}  `;
    
    };
    </script>
</body>
</html>

