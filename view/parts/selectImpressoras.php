<?php $user = new Usuario($_SESSION['username'] ?? NULL); ?>
<select name="impressora" required>
        <option value="">Selecione e Impressora</option>
        <?php if ($user->isDeveloper()) { ?>
            <option value="HUGD_PULSEIRA_TESTE">TESTE SGPTI</option>
        <?php } ?>
        <option value="HUGD-PULS-OBST01">Centro Obstétrico - Adulto</option>
        <option value="HUGD-PULS-OBST02">Centro Obstétrico - Neonato</option> 
        <option value="HUGD-PULS-RINT01">Recepção de Internação - Adulto</option>
        <option value="HUGD-PULS-RINT02">Recepção de Internação - Pediátrico</option>
        <option value="HUGD-PULS-PAGO01">Recepção de Maternidade - Adulto/Neonato</option>
        <!--option value="HUGD-PULS-PAGO01">Recepção de Maternidade - Neonato</option -->        
    </select>