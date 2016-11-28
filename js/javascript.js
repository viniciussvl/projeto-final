/* Botão submit fora do Formulário */
function submitArea(){
    if (descricaoArea.length < 4) {
        novaArea.descricaoArea.focus();
        return false;
    } 
    document.forms["novaArea"].submit();
}

function submitQuestao(){
    document.forms["formQuestao"].submit();
}

function submitAssunto(){
    document.forms["novoAssunto"].submit();
}

function submitProfessor(){
    document.forms["novoProfessor"].submit();
}

/* Validação de Formulário */
function validacao() {
    var usuario = document.getElementById("usuario").value;
    var senha = document.getElementById("senha").value;
    var confirmSenha = document.getElementById("confirmSenha").value;
    var email = document.getElementById("email").value;
    var nome = document.getElementById("nome").value;
    var erro = document.getElementById("erro");
    var maxUsuario = 16;
    var maxSenha = 32;

    if (usuario.length < 4) {
        erro.innerHTML = "Seu nome de usuário tem que ter mais de 4 caracteres!";
        formRegistro.usuario.focus();
        return false;
    }
    if (usuario.length > maxUsuario) {
        erro.innerHTML = "Seu nome de usuário não pode passar de " + maxUsuario + " caracteres!";
        formRegistro.usuario.focus();
        return false;
    }
    if (senha.length < 6) {
        erro.innerHTML = "Sua senha deve ter no minimo 6 caracteres!";
        formRegistro.senha.focus();
        return false;
    }
    if (senha != confirmSenha) {
        erro.innerHTML = "As senhas não conferem!";
        formRegistro.confirmSenha.focus();
        return false;
    }

    if (!email.match(/@/)) {
        erro.innerHTML = "Seu email deve conter um @";
        formRegistro.email.focus();
        return false;
    }
    if (nome == "") {
        erro.innerHTML = "Informe o seu nome e sobrenome!";
        formRegistro.nome.focus();
        return false;
    }
}
