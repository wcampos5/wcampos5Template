<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		//Carrega todos os recursos necessários ao Painel (titulo padrão, view padrão, rodapé, libraries e helpers(incluindo Sistema))
		initPanel(); 
		
	} //End of Contruct
	
	
	//*** FUNCTIONS ***
	
	function index() {
		$this->load->view('TBD');
	
	} /* End of TBD */
	
	/*---------------------------------------------------------------------------
	 *										Function Login()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Recebe e valida os dados recebidos do formulário
	 * - Chama o Model doLogin para verificar se usuario e senha coincide
	 *  - Configura a sessão do usuário
	 * 
	 */
	public function login() {
		/* Valida os dados recebidos do formulario */
		$this->form_validation->set_rules('email', 'USUÁRIO', 'trim|required|valid_email|strtolower');
		$this->form_validation->set_rules('password', 'SENHA', 'trim|required|min_length[4]|strtolower');
		
		//Se passar pela validação
		if ($this->form_validation->run() == TRUE){
			//Recebe os dados do formulario nas variaveis:
			$email = $this->input->post('email', TRUE); //TRUE para XSS
			//Recebe e converte para MD5SUM
			$password = md5($this->input->post('password', TRUE));
			
			/*Chama a função doLogin do Model Usuarios passando usuario e senha
			 * caso o usuario exista, senha seja correta e ele esteja ativo retorna TRUE
			 */
			
			//Login OK
			if ($this->usuarios->doLogin($email, $password) == TRUE){
				
				//Extrai o os dados do usuario do BD e alimenta a sessão
				$query = $this->usuarios->getByEmail($email)->row();	//Recebe os dados do usuario especifico
				
				//Array Dados com as variaveis de sessão
				$data = array(
						'userId' => $query->userId,
						'email'	=> $query->email,
						'name' => $query->name,
						'userAdm' => $query->adm,
						'logged' => TRUE
						
				);
				
				$this->session->set_userdata($data);
				
				redirect('painel');
				
			//Login NOT OK
			} else {
				
				$query = $this->usuarios->getByEmail($email)->row();
				
				if (empty($query)){
					setMessage('loginNotOK', 'Desculpe usuário e(ou) senha inválido(a). Tente novamente!'); //Usuario não existe
				} elseif ($query->password != $password) {
					setMessage('loginNotOK', 'Desculpe usuário e(ou) senha inválido(a). Tente novamente!'); //Senha invádlida
				} elseif ($query->active == FALSE) {
					setMessage('loginNotOK', 'Desculpe este usuario esta temporariamente inativo, contate o administrador.'); //Usuario inativo
				} else {
					setMessage('loginNotOK', 'Infelizmente ocorreu um erro desconhecido, contate o administrador!'); //Outros erros
				}
				
				redirect('usuarios/login');
			} // ./doLogin do Model Usuarios
			
		} // ./form_validation->run()
		
		/* Fim da validação do formulario */
		
		
		setTheme('titulo', 'Login'); //Define o titulo da página em painel_view()
		setTheme('conteudo', loadModule('usuarios_view', 'login')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	}  /* End of function login() */
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function logoff()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Limpa as variaveis de sistema
	 * - Destroi a sessão
	 *
	 */
	public function logoff() {
		//Defini o array dos dados que faram parte do unset
		$cleanSession = array('userId', 'email','name', 'userAdm', 'logged');
		$this->session->unset_userdata($cleanSession);
		
		//Seta a mensagem
		setMessage('logoffOK', 'Usuário desconectado com sucesso!', 'success');
		redirect('usuarios/login');
		
		$this->session->sess_destroy();
		
	}  /* End of function logoff() */
	
	
	/*---------------------------------------------------------------------------
	 *									Function nova_senha()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Enviar nova senha ao usuario
	 *
	 */
	public function nova_senha() {
		/* Valida os dados recebidos do formulario */
		$this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|strtolower');
		
		//Se passar pela validação
		if ($this->form_validation->run() == TRUE){
			//Recupera o usuario através do email
			$email = $this->input->post('email', TRUE);
			//Pega o usuario no BD
			$query = $this->usuarios->getByEmail($email);
			
			//Verifica se retornou 1 registro
			if ($query->num_rows() == 1){
				
				//Defini uma nova senha randomica com 6 digitos
				$newPassword = substr(str_shuffle('qwertyuiopasdfghjklzxcvbnm0123456789'), 0, 6);
				//Gera a mensagem para o usuário
				$mensagem = "<p>Você solicitou uma nova senha, sua nova senha é: " . " <strong>$newPassword</strong> </p>
				<p>Troque esta senha para ma senha de sua preferência.</p>";
				
				//Envia a mensagem
				if ($this->sistema->sendEmail($email, 'Nova senha de acesso', $mensagem )){
					$data['password'] = md5($newPassword);
					//Atualiza o banco de dados com a nova senha
					$this->usuarios->doUpdate($data, array('email'=>$email), FALSE);
					//Defini a mensagem de retorno para o usuario
					setMessage('msgOK', 'Nova senha enviada ao seu email', 'success');
					redirect('usuarios/nova_senha');
				
				} else {
					//Defini a mensagem de retorno para o usuario
					setMessage('msgError', 'Erro ao enviar nova senha', 'error');
					redirect('usuarios/nova_senha');				
				}
			} else {
				//Defini a mensagem de retorno para o usuario
				setMessage('msgError', 'Email inválido', 'error');
				redirect('usuarios/nova_senha');
			
			}
			
			
		} // ./form_validation->run()
		
		
		
		
		setTheme('titulo', 'Recuperar Senha'); //Define o titulo da página em painel_view()
		setTheme('conteudo', loadModule('usuarios_view', 'nova_senha')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
		
	}  /* End of function nova_senha() */
	
	
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function cadastrar()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Cadastra novos usuario
	 *
	 */
	public function cadastrar() {
		
		//Verifica se está logado
		isLogged();	
		
		//Customiza as mensagens dos campos dos formularios
		$this->form_validation->set_message('is_unique', 'Este %s já esta cadastrado no sistema');
		$this->form_validation->set_message('matches', 'O campo %s está diferente do campos %s');
		
		/* Valida os dados recebidos do formulario */
		$this->form_validation->set_rules('name', 'NOME', 'trim|required|ucwords');
		$this->form_validation->set_rules('email', 'USUÁRIO', 'trim|required|valid_email|is_unique[users.email]|strtolower');
		$this->form_validation->set_rules('password', 'SENHA', 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('password_repeat', 'REPITA A SENHA', 'trim|required|min_length[4]|strtolower|matches[password]');

		if ($this->form_validation->run() == TRUE) {
			$data = elements(array('name', 'email'), $this->input->post());
			//Criptografa a senha
			$data['password'] = md5($this->input->post('password'));
			//Se for administrador permite criar usuario com poderes administrativos
			if (isAdmin()) {
				if ($data['adm'] = $this->input->post('adm') == 1) {
					$data['adm'] = 1;
				} else {
					$data['adm'] = 0;
				}
			//Caso não seja administrador
			} else {
				$data['adm'] = 0;
			}
			
			//Insere no banco de dados
			$this->usuarios->doInsert($data);
		}		
		
		setTheme('titulo', 'Cadastro de Usuários'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('usuarios_view', 'cadastrar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	}  /* End of Function cadastrar() */
	
	
	/*---------------------------------------------------------------------------
	 *									Function gerenciar()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Listagem de usuarios usando JQuery Data Tables
	 *
	 */
	public function gerenciar() {
		
		//Verifica se esta logado
		isLogged();
		
		$this->load->helper('html');
		
		//Carrega o data-table.js e o tabel.js
		setTheme('jsInclude', loadJS('table.js', 'assets/js', FALSE),FALSE);
		
		
		
		setTheme('titulo', 'Gerenciamento de usuários'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('usuarios_view', 'gerenciar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
		
	}  /* End of function_gerenciar */
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function alterar_senha()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Altera a senha do usuario
	 *
	 */
	public function alterar_senha() {
	
		//Verifica se esta logado
		isLogged();
		
		//Valida form
		$this->form_validation->set_message('matches', 'O campo %s está diferente do campos %s');
		
		$this->form_validation->set_rules('password', 'SENHA', 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('password_repeat', 'REPITA A SENHA', 'trim|required|min_length[4]|strtolower|matches[password]');
		
		if ($this->form_validation->run() == TRUE) {
			//Recebe a senha
			$data['password'] = md5($this->input->post('password'));
			
			//Altera a senha no BD
			$this->usuarios->doUpdate($data, array('userId'=>$this->input->post('userId')));
		}
	
		setTheme('titulo', 'Alterar Senha'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('usuarios_view', 'alterar_senha')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	
	}  /* End of function alterar_senha */
	
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function editar()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Permite a edição de alguns dados do usuario
	 *
	 */
	public function editar() {
	
		//Verifica se esta logado
		isLogged();
		
		/* Valida os dados recebidos do formulario */
		$this->form_validation->set_rules('name', 'NOME', 'trim|required|ucwords');
		
		//Se passar pela validação
		if ($this->form_validation->run() == TRUE) {
			//O nome
			$data['name'] = $this->input->post('name', TRUE);
			
			//Somente um administrador pode criar outro ou Inativar um usuario
			if (isAdmin(TRUE)){
				$data['active'] = ($this->input->post('active') == 1) ? 1 : 0;
			}
			
			if (isAdmin(TRUE)){
				$data['adm'] = ($this->input->post('adm') == 1) ? 1 : 0;
			}
			
			//Altera a senha no BD
			$this->usuarios->doUpdate($data, array('userId'=>$this->input->post('userId')));
		}
		
	
		setTheme('titulo', 'Atualização de Usuario'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('usuarios_view', 'editar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	
	}  /* End of function editar */
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function excluir()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Permite a exclusão de um usuario
	 *
	 */
	public function excluir() {
	
		//Verifica se esta logado
		isLogged();
	
		//Verifica se é administrador
		if (isAdmin(TRUE)){
			
			//Recebe o userId no 3o segmento da URI
			$userIdSegment = $this->uri->segment(3);
			
			//Caso o 3o segmento exista
			if ($userIdSegment != NULL){
				
				//Retorna a linha correspondente do banco de dados
				$query = $this->usuarios->getByUserId($userIdSegment);
				
				//Se retornar uma linha
				if ($query->num_rows() == 1){
					
					$query->row();
					
					
					//Verifica se o usuario em questão não é um administrador
					if ($query->adm != '1'){
						//Executa a deleção
						$this->usuarios->doDelete(array('userId'=>$query->userId), FALSE);
					//Caso não $query->adm != '1'
					} else {
						setMessage('msgError', 'Usuário não pode ser excluido!!!', 'error');
					} // ./End of $query->adm != '1'
					
				//Caso não $query->num_rows() <> 1
				} else {
					setMessage('msgError', 'Usuário Inexisente', 'error');
				} // ./End of $query->num_rows() == 1
				
			//Caso $userIdSegment == NULL
			} else {
				setMessage('msgError', 'Selecione um usuário para deletar', 'error');
			
			} // ./End of $userIdSegment != NULL
			
			redirect('usuarios/gerenciar');
			
		} // ./End of isAdmin(TRUE)
	
	}  /* End of function editar */
	
	
	
	
	
	
		
	
} //End of Controller Usuarios

/*   End of file usuarios.php  */
/*   Location: ./application/controllers/usuarios.php  */