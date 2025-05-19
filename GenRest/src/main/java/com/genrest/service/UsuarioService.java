package com.genrest.service;

import java.util.List;
import java.util.Random;

import javax.mail.MessagingException;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.authority.AuthorityUtils;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.core.userdetails.User;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import com.genrest.model.Permissao;
import com.genrest.model.Usuario;
import com.genrest.repository.ConfirmacaoRepository;
import com.genrest.repository.RecuperacaoRepository;
import com.genrest.repository.UsuarioRepository;

@Service
public class UsuarioService implements UserDetailsService{

	@Autowired
	private UsuarioRepository repository;

	@Autowired
	private RecuperacaoRepository recuperacaoRepository;

	@Autowired
	private ConfirmacaoRepository confirmacaoRepository;


	@Autowired
	private EmailService emailService;

	@Transactional(readOnly = true)
	public Usuario buscarPorEmail(String email) {
		return repository.findByEmail(email);
	}
	
	//autenticação de usuário (spring-security)
	@Override @Transactional(readOnly = true)
	public UserDetails loadUserByUsername(String email) throws UsernameNotFoundException {
		Usuario usuario = buscarPorEmail(email);
		
		return new User(
				usuario.getEmail(),
				usuario.getSenha(),
				AuthorityUtils.createAuthorityList(getAuthorities(usuario.getPermissoes()))
		);
	}

	//converte lista de permissoes para array string
	public String[] getAuthorities(List<Permissao> permissoes) {
		String[] authorities = new String[permissoes.size()];
		
		for (int i = 0; i < permissoes.size(); i++) {
			authorities[i] = permissoes.get(i).getDesc();
		}
		return authorities;
	}
	
	@Transactional(readOnly = true)
	public Usuario getUsuarioAutenticado() {
		Object principal = SecurityContextHolder.getContext().getAuthentication().getPrincipal();
		String usuario;
		
		if (principal instanceof UserDetails) {
			usuario = ((UserDetails)principal).getUsername();
		} else {
			usuario = principal.toString();
		}
		return repository.findByEmail(usuario);
	}

	@Transactional(readOnly = true)
    public boolean cpfCnpjExiste(String cpfCnpj) {
        if(repository.findByCpfCnpj(cpfCnpj) != null)
			return true;
		return false;
    }

    @Transactional(readOnly = true)
    public boolean emailExiste(String email) {
        if(repository.findByEmail(email) != null)
			return true;
		return false;
    }

    @Transactional(readOnly = false)
    public void cadastrar(Usuario usuario) {
		String senhaCriptografada = new BCryptPasswordEncoder().encode(usuario.getSenha());
		usuario.setSenha(senhaCriptografada);
		usuario.setPlano(0);
		usuario.setQtdFuncoes(0L);
		usuario = repository.save(usuario);
		repository.insertPermissao(usuario.getId(), 1);
    }
	
    @Transactional(readOnly = false)
	public void cadastrarToken(Usuario usuario) throws MessagingException{
		Long clienteId = usuario.getId();
		int token = getToken();
		recuperacaoRepository.salvarRecuperacao(clienteId, token);
		emailService.enviarRecuperacaoSenha(usuario.getEmail(),(long) token);
	}

	@Transactional(readOnly = false)
	public void cadastrarConfirmacao(Usuario usuario) throws MessagingException {
		Long clienteId = usuario.getId();
		int token = getToken();
		confirmacaoRepository.salvarConfirmacao(clienteId, token);
		emailService.enviarPedidoDeConfirmacaoDeCadastro(usuario.getEmail(),(long) token);
	}
	
	private int getToken() {
		Random gerador = new Random();
		int token = gerador.nextInt();
		if (token < 0)
			token = token * -1;
		
		return token;
	}

	@Transactional(readOnly = false)
    public boolean salvarConta(Usuario usuario) {
		try{
			Usuario user = getUsuarioAutenticado();
			usuario.setId(user.getId());
			usuario.setQtdFuncoes(user.getQtdFuncoes());
			usuario.setPermissoes(user.getPermissoes());

			if((usuario.dadosBancoMudou(user) && usuario.getPermissoes().get(0).getId() == 3) || usuario.getPermissoes().get(0).getId() == 1){
				repository.updatePermissao(usuario.getId(), 2);
			}
			if(usuario.getSenha().length() == 0 || usuario.getSenha() == null) {				
				usuario.setSenha(user.getSenha());
			}else {
				String senhaCriptografada = new BCryptPasswordEncoder().encode(usuario.getSenha());
				usuario.setSenha(senhaCriptografada);				
			}
			if(usuario.getSenhaDatabase().length() == 0 || usuario.getSenhaDatabase() == null)
				usuario.setSenhaDatabase(user.getSenhaDatabase());
			
			usuario.setVerificado(user.getVerificado());
			repository.save(usuario);
			return true;
		}catch(Exception ex){
			return false;
		}
	}

	@Transactional(readOnly = false)
	public void setClienteVerificadoByClienteId(Long clienteId) {
		repository.ConfirmaEmail(clienteId);
	}

	@Transactional(readOnly = false)
	public void setConfirmacaoUsado(Long clienteId) {
		confirmacaoRepository.setaConfirmacaoUsado(clienteId);
	}

	@Transactional(readOnly = false)
	public void setNovaSenha(Long clienteId, String novaSenha) {
		String senhaCriptografada = new BCryptPasswordEncoder().encode(novaSenha);
		repository.alteraSenha(clienteId, senhaCriptografada);
	}

	@Transactional(readOnly = false)
	public void setRecuperacaoUsado(Long clienteId) {
		recuperacaoRepository.setaRecuperacaoUsado(clienteId);
	}
}
