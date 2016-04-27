<h4 class="header">Dados pessoais</h4>

<blockquote>
    <ul>
        <li>
            <strong>Nome:</strong>
            <span><?= $usuario->nome ?></span>
        </li>
        <li>
            <strong>Data de Nascimento:</strong>
            <span><?= $usuario->data_nascimento ?></span>
        </li>
        <li>
            <strong>Email:</strong>
            <span><?= $usuario->email ?></span>
        </li>
        <li>
            <strong>Email Institucional:</strong>
            <span><?= $usuario->email_institucional ?></span>
        </li>
        <li>
            <strong>CPF:</strong>
            <span><?= $usuario->cpf ?></span>
        </li>
        <li>
            <strong>Sexo:</strong>
            <span><?= $usuario->masculino == 1 ? "Masculino" : "Feminino" ?></span>
        </li>        
    </ul>
</blockquote>

<h4 class="header">Dados de Acesso</h4>

<blockquote>
    <ul>
        <li>
            <strong>Username:</strong>
            <span><em><?= $usuario->username ?></em></span>
        </li>        
    </ul>
</blockquote>

