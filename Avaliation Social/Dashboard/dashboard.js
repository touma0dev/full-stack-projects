document.addEventListener('DOMContentLoaded', function () {
    var modeSwitch = document.querySelector('.mode-switch');

    modeSwitch.addEventListener('click', function () {
        document.documentElement.classList.toggle('dark');
        modeSwitch.classList.toggle('active');

    });
    // Seleciona o elemento do ícone do usuário
    const avatar = document.getElementById("avatar");

    // Adiciona um ouvinte de eventos para alterar a cor do ícone com base no modo escuro/claro
    document.addEventListener("DOMContentLoaded", function () {
        var modeSwitch = document.querySelector('.mode-switch');

        modeSwitch.addEventListener('click', function () {
            document.documentElement.classList.toggle('dark');
            modeSwitch.classList.toggle('active');

            // Altera a cor do ícone com base no modo escuro/claro
            if (document.documentElement.classList.contains('dark')) {
                avatar.setAttribute("fill", "#FFF");
            } else {
                avatar.setAttribute("fill", "#1f1c2e");
            }
        });
    });

    var listView = document.querySelector('.list-view');
    var gridView = document.querySelector('.grid-view');
    var projectsList = document.querySelector('.project-boxes');

    listView.addEventListener('click', function () {
        gridView.classList.remove('active');
        listView.classList.add('active');
        projectsList.classList.remove('jsGridView');
        projectsList.classList.add('jsListView');
    });

    gridView.addEventListener('click', function () {
        gridView.classList.add('active');
        listView.classList.remove('active');
        projectsList.classList.remove('jsListView');
        projectsList.classList.add('jsGridView');
    });

    document.querySelector('.messages-btn').addEventListener('click', function () {
        document.querySelector('.messages-section').classList.add('show');
    });

    document.querySelector('.messages-close').addEventListener('click', function () {
        document.querySelector('.messages-section').classList.remove('show');
    });
});
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
