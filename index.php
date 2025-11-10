
<?php


session_start();

$API_BASE = "https://www.ihaclabi.ufba.br/api.php/records";

?>

 <script>


  
</script>

<?php
$mensagemProjetos = "";
$mensagemRecursos = "";
$dadosJS = "[]"; 

if (isset($_GET['NFCId'])) {
    $NFCId = $_GET['NFCId'];

    $url = "https://www.ihaclabi.ufba.br/api.php/records/vwAlocacoes?filter=NFCId,eq," . $NFCId;
    $arrContextOptions = [
        "ssl" => [
            "verify_peer"      => false,
            "verify_peer_name" => false,
        ],
    ];  

    $content = file_get_contents($url, false, stream_context_create($arrContextOptions));

    if ($content !== FALSE) {
        $json_data = json_decode($content, true);

        if (!empty($json_data['records'])) {
            $nome = $json_data['records'][0]['Nome'];
            $dadosJS = json_encode($json_data['records']); 

            // Projetos únicos
            $projetos = [];
            foreach ($json_data['records'] as $registro) {
                $idProjeto   = $registro['Projeto_idProjeto'];
                $descProjeto = $registro['descProjeto'];
                $dtInicio    = $registro['dtInicio'];
                $dtFim       = $registro['dtFim'];
                $tipoProjeto = $registro['descTipoProjeto'];

                if (!isset($projetos[$idProjeto])) {
                    $projetos[$idProjeto] = "$descProjeto | $dtInicio - $dtFim ($tipoProjeto)";
                }
            }

            foreach ($projetos as $idProjeto => $textoProjeto) {
                $mensagemProjetos .= "<option value='$idProjeto'>$textoProjeto</option>";
            }
        }
    }
}
?>

<?php
$usuarioNome = "Nome do Usuário";
$usuarioCargo = "Cargo/Função";
$avatarPath = "avatar/default.jpg";

if (!empty($NFCId) && !empty($json_data['records'])) {
    $record = $json_data['records'][0];
    $usuarioNome = $record['Nome'];
    $usuarioCargo = $record['descTipoUsuario'];
    $avatarPath = !empty($record['ImagePath']) ? $record['ImagePath'] : $avatarPath;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <title>Controle de Acesso</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700&display=swap" rel="stylesheet" />
  
  <script>

  </script>
  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f7e79b 0%, #a08b00 100%);
    font-family: 'Segoe UI', Arial, sans-serif;
    height: 100vh;
    overflow: hidden;
  }

  .main-container {
    width: 1024px;
    height: 1440px;
    background: #F4E600;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    padding: 30px;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
  }

  .bg-top{

    position: absolute;
    width: 900px;
    height: auto;
    pointer-events: none;
    z-index: 0;
    opacity: 0.7;
  } 
  
  .bg-bottom {
    position: absolute;
    width: 900px;
    height: auto;
    pointer-events: none;
    z-index: 0;
    opacity: 0.7;
  }

  .bg-top { top: 0; left: 0; }
  .bg-bottom { bottom: 0; right: 0; }

  .status-message {
    width: 950px;
    height: 120px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #06426A;
    border-radius: 20px;
    margin-top: 20px;
    margin-bottom: 30px;
    z-index: 1;
    position: relative
  }

  .aproxime {
    font-size: 2.5rem;
    color: #eeeaeaff;
    font-weight: bold;
    text-shadow: 1px 1px 3px hsla(0, 0%, 0%, 0.30);
    transition: opacity 1s ease;
    opacity: 80%;
  }

  .aproxime.fade-out { opacity: 0; }

  .profile-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-grow: 1;
    z-index: 1;
  }

  .avatar {
    width: 600px;
    height: 600px;
    border-radius: 50%;
    border: 8px solid #ddd;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
    background: url('Logo-sem-Texto-preta.png') center center / contain no-repeat;
    background-color: #23a49b;
  }

  .user-info {
    color: #000;
    margin-bottom: 30px;
    text-align: center;
  }

  .user-name {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
  }

  .user-description {
    font-size: 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 12px 30px;
    border-radius: 25px;
    margin-bottom: 20px;
  }

  .user-message {
    font-size: 1.8rem;
    line-height: 1.4;
    max-width: 600px;
    margin: 0 auto 15px;
  }

  .rfid-box {
    width: 802px;
            height: 268px;
            background: #06426A;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            font-size: 64px;
            font-weight: 700;
            text-transform: uppercase;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
            position: relative;
  }

  .controls {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 270px;
  margin-top: 20px;
  margin-bottom: 20px;
  z-index: 1;
}

.control-btn {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  border: none;
  color: white;
  font-size: 5rem;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.25s ease;
  display: flex;
  justify-content: center;
  align-items: center;
  user-select: none;
  box-shadow: 0 6px 12px rgba(0,0,0,0.2);
  line-height: 0; /* ✅ mantém o ícone centralizado verticalmente */
  text-align: center; /* ✅ garante o alinhamento horizontal */
}

.botao-esquerda {
  background: linear-gradient(145deg, #f08334, #c05a0c);
  box-shadow: 0 6px 12px #c05a0c;
  transform: rotate(270deg); /* ✅ Rotaciona o botão para baixo */
  display: flex;
  justify-content: center;
  align-items: center;
}

.botao-esquerda:hover {
  box-shadow: 0 10px 20px #c05a0c;
  filter: brightness(1.1);
  transform: rotate(270deg) scale(1.1); /* mantém a rotação no hover */
}

.botao-esquerda:active {
  box-shadow: 0 4px 8px #c05a0c;
  filter: brightness(0.9);
  transform: rotate(270deg) scale(0.95); /* mantém a rotação no clique */
}

.botao-direita {
  background: linear-gradient(145deg, #7fbc4d, #4e7430);
  box-shadow: 0 6px 12px #4e7430;
  display: flex;
  justify-content: center;
  align-items: center;
}

.botao-direita:hover {
  box-shadow: 0 10px 20px #4e7430;
  filter: brightness(1.1);
  transform: scale(1.1);
}

.botao-direita:active {
  box-shadow: 0 4px 8px #4e7430;
  filter: brightness(0.9);
  transform: scale(0.95);
}

.projetos-box, 
.recursos-box {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 10px auto;
  width: 100%;
  height: 100%;
}

.projetos-box select, 
.recursos-box select {
  width: 100%;
  height: 100%; 
  background: #06426A
; 
  color: #fff; 
  border: none; 
  border-radius: 15px;
  padding: 20px;
  font-size: 1.8rem; 
  font-weight: bold;
  text-align: center;
  line-height: 1.4;
  outline: none;
  box-shadow: none;
  appearance: none; 
  -webkit-appearance: none;
  -moz-appearance: none;
  overflow: hidden; 
  white-space: nowrap; 
  text-overflow: ellipsis; 
}

.projetos-box select option, 
.recursos-box select option {
  background: 
  #000000ff;
  color: #fff;
  font-size: 1.6rem; /* menor que o select */
  padding: 10px;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}

/* Hover com cor padrão */
.projetos-box select:hover, 
.recursos-box select:hover {
  background: #111;
  color: #f5e900ff;
  transform: scale(1.01);
}

/* Confirmação estilizada */
#confirm {
  position: absolute;
  top: 10%;
  left: 50%;
  transform: translateX(-50%);
  background: #000;
  color: #f4e600;
  padding: 25px 40px;
  border-radius: 15px;
  font-size: 1.8rem;
  font-weight: bold;
  display: none;
  z-index: 1000;
  text-align: center;
  box-shadow: 0 8px 20px rgba(0,0,0,0.6);
  animation: pulse 1.5s infinite;
}

  #mensagem {
    font-size: 30px; /* ✅ Reduzido significativamente */
    font-weight: 700;
    text-transform: uppercase;
    transition: opacity 0.8s ease-in-out;
    opacity: 1;
    line-height: 1.1; /* ✅ Reduzido o line-height */
    max-width: 95%; /* ✅ Aumentado para usar mais espaço disponível */
    text-align: center;
    word-wrap: break-word; /* ✅ Quebra palavras longas se necessário */
    padding: 5px 10px
  }

  .fade-out {
    opacity: 0;
  }

@keyframes pulse {
  0% { transform: translateX(-50%) scale(1); opacity: 1; }
  50% { transform: translateX(-50%) scale(1.05); opacity: 0.9; }
  100% { transform: translateX(-50%) scale(1); opacity: 1; }
}
</style>
  <script>
    function carregarRecursos(projetoSelecionado){
        const recursosSelect = document.getElementById("recursos");
        const registros = <?php echo $dadosJS; ?>;
    
        recursosSelect.innerHTML = "";

        const recursosFiltrados = registros.filter(r => r.Projeto_idProjeto == projetoSelecionado);

        if(recursosFiltrados.length > 0){
            recursosFiltrados.forEach(r => {
                const opt = document.createElement("option");
                opt.value = r.Recurso_idRecurso;
                opt.textContent = `${r.descRecurso} (${r.descTipoRecurso})`;
                recursosSelect.appendChild(opt);
            });
        } else {
            const opt = document.createElement("option");
            opt.disabled = true;
            opt.textContent = "Nenhuma ação vinculada a este projeto";
            recursosSelect.appendChild(opt);
        }
    }
     </script>
</head>
<body>

  <div class="main-container">

    <!-- Imagens decorativas dentro do frame -->
    <img src="Group 2.png" alt="Decor Top" class="bg-top">
    <img src="Group 3.png" alt="Decor Bottom" class="bg-bottom">

  <div class="status-message"> 
    <div class="aproxime" id="mensagem">
        
    </div>
</div>

    <button id="conectar" style="visibility: hidden;">Conectar ao Arduino</button>
    <pre id="saida"></pre>

    <div class="profile-section">
      <div class="avatar"></div>
      <div class="user-info">
        <h1 class="user-name"><?php echo $usuarioNome; ?></h1>
        <div class="user-description"><?php echo $usuarioCargo; ?></div>
    </div>

<p class="user-message">Bem-vindo ao sistema de controle de acesso</p>
<div class="rfid-box">

<?php if (!empty($NFCId)) { ?>
  
 <div class="projetos-box">
  <select name="Projetos" id="projetos" multiple>
    <?php 
      if (!empty($mensagemProjetos)) {
        echo $mensagemProjetos;
      }  else {
        echo '<option disabled>-- Nenhum projeto disponível --</option>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                  const popup = document.createElement("div");
                  popup.style.position = "absolute";
                  popup.style.top = "10%";
                  popup.style.left = "50%";
                  popup.style.transform = "translateX(-50%)";
                  popup.style.background = "#f39c12";
                  popup.style.color = "white";
                  popup.style.padding = "50px 50px";
                  popup.style.fontSize = "2.5rem"
                  popup.style.borderRadius = "5px";
                  popup.style.display = "none";
                  popup.style.zIndex = "1000";
                  popup.textContent = "RFID Não cadastrado: Contate o professor para cadastrar o RFID ' . $NFCId . '";
                  document.body.appendChild(popup);

                  // Exibir o popup
                  popup.style.display = "block";

                  
                  setTimeout(() => {
                    popup.style.display = "none";
                    popup.remove();
                  }, 8000);
                });
              </script>';
      }
    ?>
    <option value="sair">Sair</option>
  </select>
</div>

<div class="recursos-box">
  <select name="Recursos" id="recursos" multiple>
    <option disabled>Selecione um projeto primeiro</option>
    <option value="sair">Sair</option>
  </select>
</div>

<div id="confirm" style="display:none; color:yellow; text-align:center; margin-top:10px;"></div>
<?php } else { ?>
  <div class="status-message">
    <div id="mensagem">Aproxime o seu cartão RFID</div>
  </div>
<?php } ?>

<!-- Mensagem de confirmação -->
<div id="confirm" style="
    position: fixed;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    background: #f39c12;
    color: white;
    padding: 15px 25px;
    border-radius: 5px;
    display: none;
    z-index: 1000;">
    Deseja realmente registrar esse acesso? Pressione → para confirmar.
</div>

</div>


    </div>

    <div class="controls">
      <button class="control-btn botao-esquerda">&#9664;</button>
      <button class="control-btn botao-direita">&#9654;</button>
    </div>

  </div>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const mensagemEl = document.getElementById("mensagem");
    if (!mensagemEl) return; // ✅ não faz nada se o elemento não existir (ex: quando NFCId está presente)
    const mensagens = [
      "APROXIME O SEU CARTÃO CADASTRADO",
      "IHAC LAB-I",
      "ESPAÇO ABERTO DE CRIAÇÃO E INOVAÇÃO"
    ];
    let index = 0;
    mensagemEl.textContent = mensagens[0];
    setTimeout(() => {
      setInterval(() => {
        mensagemEl.classList.add("fade-out");
        setTimeout(() => {
          index = (index + 1) % mensagens.length;
          mensagemEl.textContent = mensagens[index];
          mensagemEl.classList.remove("fade-out");
        }, 800);
      }, 3000);
    }, 800);
  });


document.addEventListener('DOMContentLoaded', async () => {
  // 1. Get the current URL
        const urlAtual = window.location.href;

        // 2. Create a URL object
        const urlObjeto = new URL(urlAtual);

        // 3. Access searchParams
        const parametrosURL = urlObjeto.searchParams;

        // 4. Use get() to retrieve a specific parameter
        const NFCId = parametrosURL.get("NFCId");
      //let porta=window.porta;
      try {
        let ports = await navigator.serial.getPorts();
        if (ports.length > 0) {
          window.porta = ports[0];
          if (window.porta.connected){
           // await window.porta.close();
            await window.porta.open({ baudRate: 9600 });
          }
          

          /*const decoder = new TextDecoderStream();
          porta.readable.pipeTo(decoder.writable);
          const reader = decoder.readable.getReader();*/

          const reader = window.porta.readable.getReader();
         
          while (true) {
            const { value, done } = await reader.read();
            if (done) break;

            if (value) {
              const utf8decoder = new TextDecoder();
              const valor = utf8decoder.decode(value);

              if (!NFCId) { 
                  if ((valor[0] != 'D') && (valor[0] != 'E')) {
                    const url = "index.php?NFCId=" + utf8decoder.decode(value);
                    window.location.href = url;
                  }
              } else {
                  if (valor[0] == 'D') {
                      const e = new KeyboardEvent("keydown", { key: "ArrowDown" });
                      document.dispatchEvent(e); // ✅ mudou aqui
                  } 
                  else if (valor[0] == 'E') {
                      const e = new KeyboardEvent("keydown", { key: "ArrowRight" });
                      document.dispatchEvent(e); // ✅ já estava certo
                  }
              }
            }
          }

            
        } else {
          document.document.getElementById("conectar").style.visibility = "visible";
        }

      
    
      } catch (err) {
        alert("Erro: " + err);
       // document.getElementById("conectar").style.visibility = "visible";
        //if (porta) porta.close();
      }
      // Populate the UI with options for the user to select or
      // automatically connect to devices.
    });
    document.getElementById("conectar").addEventListener("click", async () => {
      let porta=null;
      try {
        const ports = await navigator.serial.getPorts();
       // if (ports.length > 0) {
       //    porta = ports[0];
       // } else {
          // Solicita acesso ao dispositivo serial
            window.porta  = await navigator.serial.requestPort();
        //}
          if ( window.porta .connected){
            await  window.porta .open({ baudRate: 9600 });
          }

                 /*const decoder = new TextDecoderStream();
          porta.readable.pipeTo(decoder.writable);
          const reader = decoder.readable.getReader();*/

          const reader =  window.porta .readable.getReader();
         
          while (true) {
            const { value, done } = await reader.read();
            if (done) break;
            if (value) {
              //saida.textContent += "Recebido: " + value;
              const utf8decoder = new TextDecoder();

              const url= "index.php?NFCId="+utf8decoder.decode(value);
              window.location.href = url;
          }
        }
      } catch (err) {
        alert("Erro: " + err);
       // if (porta) porta.close();
      }
    });
  </script>






<script>
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => window.location.href = "index.php", 10000);
    const registros = <?php echo $dadosJS; ?>;
    const projetosSelect = document.getElementById("projetos");
    const recursosSelect = document.getElementById("recursos");
    const confirmDiv = document.getElementById("confirm");
    let focoAtual = "projetos";
    let confirmando = false;
    let idSelecionado = null;

    if (projetosSelect) projetosSelect.focus();

    function carregarRecursos(projetoSelecionado) {
        recursosSelect.innerHTML = "";
        const filtrados = registros.filter(r => r.Projeto_idProjeto == projetoSelecionado);

        if (filtrados.length > 0) {
            const vistos = new Set();
            filtrados.forEach(r => {
                if (!vistos.has(r.Recurso_idRecurso)) {
                    const opt = document.createElement("option");
                    opt.value = r.idUsuarioXProjetoXRecurso;
                    opt.textContent = r.descRecurso + " (" + r.descTipoRecurso + ")";
                    recursosSelect.appendChild(opt);
                    vistos.add(r.Recurso_idRecurso);
                }
            });
        } else {
            const opt = document.createElement("option");
            opt.disabled = true;
            opt.textContent = "Nenhuma ação encontrada";
            recursosSelect.appendChild(opt);
        }

        const sairOpt = document.createElement("option");
        sairOpt.value = "sair";
        sairOpt.textContent = "Sair";
        recursosSelect.appendChild(sairOpt);

        recursosSelect.selectedIndex = 0;
    }

    function registrarAcesso(idUsuarioXProjetoXRecurso) {
        if (!idUsuarioXProjetoXRecurso || idUsuarioXProjetoXRecurso === "sair") return;

        fetch("https://www.ihaclabi.ufba.br/api.php/records/acessos", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
                UsuarioXProjetoXRecurso_idUsuarioXProjetoXRecurso: idUsuarioXProjetoXRecurso
            })
        })
        .then(res => res.json())
        .then(() => {
            confirmDiv.textContent = "✅ Ação registrada com sucesso!";
            confirmDiv.style.display = "block";
            setTimeout(() => window.location.href = "index.php", 1200);
        })
        .catch(err => console.error("Erro ao registrar acesso:", err));
    }


    document.addEventListener("keydown", (e) => {
        if (!projetosSelect || !recursosSelect) return;

        // ↓ Navegação (dentro do select atual)
        if (e.key === "ArrowDown") {
            const selectAtual = focoAtual === "projetos" ? projetosSelect : recursosSelect;
            if (selectAtual.options.length > 0) {
                let idx = selectAtual.selectedIndex;
                idx = (idx + 1) % selectAtual.options.length;
                selectAtual.selectedIndex = idx;
            }

            // Atualiza os recursos em tempo real ao navegar nos projetos
            if (focoAtual === "projetos") {
                const projetoSelecionado = projetosSelect.value;
                carregarRecursos(projetoSelecionado);
            }

            e.preventDefault();
        }

        // → Avança ou confirma ação
        if (e.key === "ArrowRight") {
            if (focoAtual === "projetos") {
                const projetoSelecionado = projetosSelect.value;
                if (projetoSelecionado) {
                    carregarRecursos(projetoSelecionado);
                    focoAtual = "recursos";
                    recursosSelect.focus();
                }
            } else if (focoAtual === "recursos") {
                idSelecionado = recursosSelect.value;
                if (idSelecionado === "sair") {
                    window.location.href = "index.php";
                    return;
                }

                if (!confirmando) {
                    confirmando = true;
                    confirmDiv.textContent = "Confirmar esta ação? Pressione → novamente para enviar.";
                    confirmDiv.style.display = "block";
                } else {
                    confirmDiv.style.display = "none";
                    registrarAcesso(idSelecionado);
                    confirmando = false;
                }
            }
            e.preventDefault();
        }

        // ← Volta para os projetos
        if (e.key === "ArrowLeft" && focoAtual === "recursos") {
            focoAtual = "projetos";
            projetosSelect.focus();
            confirmDiv.style.display = "none";
            confirmando = false;
            e.preventDefault();
        }
    });
});
</script>
</body>
</html>
