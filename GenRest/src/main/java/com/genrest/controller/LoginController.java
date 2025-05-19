package com.genrest.controller;

import java.util.Optional;
import java.util.List;

import javax.mail.MessagingException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import com.genrest.model.Recuperacao;
import com.genrest.model.Confirmacao;
import com.genrest.model.Usuario;
import com.genrest.repository.ConfirmacaoRepository;
import com.genrest.repository.RecuperacaoRepository;
import com.genrest.repository.UsuarioRepository;
import com.genrest.service.LogService;
import com.genrest.service.UsuarioService;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.web.authentication.session.SessionAuthenticationException;
import org.springframework.stereotype.Controller;
import org.springframework.validation.Errors;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

@Controller
public class LoginController {
    
    @Autowired
	LogService logService;		

	@Autowired
	UsuarioService usuarioService;

    @Autowired
	UsuarioRepository usuarioRepository;

	@Autowired
	RecuperacaoRepository recuperacaoRepository;

	@Autowired
	ConfirmacaoRepository confirmacaoRepository;
	/*
	@RequestMapping("/")
	public ModelAndView land() {
		ModelAndView mv = new ModelAndView("usuario/Genrest");
		return mv;
	}
	 */
    @RequestMapping({"","/","/login"})
	public ModelAndView login() {
		ModelAndView mv = new ModelAndView("usuario/Login");
		return mv;
	}

	@RequestMapping("/cadastrar")
	public ModelAndView cadastrar(@Validated Usuario usuario, Errors error, RedirectAttributes attributes) throws MessagingException {
		ModelAndView mv = new ModelAndView("usuario/Login");
		mv.addObject(usuario);
		if(error.hasErrors()){
			System.out.println("Erro no objeto");
			return mv;
		}
		if(usuarioService.cpfCnpjExiste(usuario.getCpfCnpj()) || usuarioService.emailExiste(usuario.getEmail())){
			mv.addObject("usuarioExiste", true);
			if(usuarioService.cpfCnpjExiste(usuario.getCpfCnpj())){
				mv.addObject("cpfCnpjExiste", "CPF/CNPJ já existe.");
			}
			if(usuarioService.emailExiste(usuario.getEmail())){
				mv.addObject("emailExiste", "E-mail já existe.");
			}
			return mv;
		}
		usuarioService.cadastrar(usuario);
		usuarioService.cadastrarConfirmacao(usuario);
		mv.addObject("cadastrado", true);
		return mv;
	}

    @RequestMapping("/recuperar-senha")
	public ModelAndView recuperarSenha(@Validated Usuario usuario, Errors error, RedirectAttributes attributes) throws MessagingException {
        ModelAndView mv = new ModelAndView("usuario/Login");
        usuario = usuarioRepository.findByEmail(usuario.getEmail());
        if(usuario != null)
            usuarioService.cadastrarToken(usuario);
		
		mv.addObject("recuperacao_enviado", true);
		return mv;
	}

    // acesso negado
	@RequestMapping("/acesso-negado")
	public ModelAndView acessoNegado(HttpServletResponse resp) {
		if (usuarioService.getUsuarioAutenticado().getVerificado() == 0) {
			ModelAndView mv = new ModelAndView("redirect:/login?naoAutenticado");
			return mv;
		}

		ModelAndView mv = new ModelAndView("usuario/Acesso-negado");
		mv.addObject("status", resp.getStatus());
		mv.addObject("error", "Acesso Negado");
		mv.addObject("message", "você não tem permissão para acesso a esta área ou ação.");
		return mv;
	}

	@RequestMapping("/nova-senha")
	public ModelAndView novaSenha(@RequestParam Optional<Long> token) {
		ModelAndView mv;
		List<Recuperacao> lista = recuperacaoRepository.RetornaRecuperacaoToken(token);

		if(lista.isEmpty() || token.isEmpty()) {
			mv = new ModelAndView("usuario/Login");
			mv.addObject("token_invalido", true);
			return mv;
		}

		mv = new ModelAndView("usuario/Nova-senha");
		mv.addObject("token", token);
		mv.addObject("cliente_id", lista.get(0).getClienteId());
		return mv;
	}

	@RequestMapping("/cadastrar-nova-senha")
	public ModelAndView cadastrarNovaSenha(@Validated Usuario usuario, Errors error, RedirectAttributes attributes) {
		ModelAndView mv = new ModelAndView("usuario/Login");
		usuarioService.setNovaSenha(usuario.getId(), usuario.getSenha());
		usuarioService.setRecuperacaoUsado(usuario.getId());
		mv.addObject("senha_alterada", true);
		return mv;
	}

	@RequestMapping("/confirmacao")
	public ModelAndView Confirmacao(@RequestParam Optional<Long> token) {
		List<Confirmacao> lista = confirmacaoRepository.RetornaConfirmacaoToken(token);
		ModelAndView mv = new ModelAndView("usuario/Login");
		if (lista.isEmpty() || token.isEmpty()) {
			mv.addObject("token_invalido", true);
			return mv;
		}
		Long clienteId = lista.get(0).getClienteId();
		usuarioService.setClienteVerificadoByClienteId(clienteId);
		usuarioService.setConfirmacaoUsado(clienteId);
		mv.addObject("email_confirmado", true);
		return mv;
	}

	@RequestMapping("/login-error")
	public ModelAndView erroLogin(HttpServletResponse resp, HttpServletRequest req) {
		ModelAndView mv = new ModelAndView("usuario/Login");
		HttpSession session = req.getSession();
		String lastException = String.valueOf(session.getAttribute("SPRING_SECURITY_LAST_EXCEPTION"));
		if(lastException.contains(SessionAuthenticationException.class.getName())){
			mv.addObject("message", "você já está logado em outro dispositivo.");
			mv.addObject("submessage", "Faça o logout ou espere sua sessão expirar.");
			return mv;
		}
		mv.addObject("message", "Usuario ou Senha invalidos.");
		return mv;
	}
	
	@RequestMapping("/expired")
	public ModelAndView sessaoExpirada() {
		ModelAndView mv = new ModelAndView("usuario/Login");
		mv.addObject("message", "Acesso recusado.");
		mv.addObject("submessage", "Você logou em outro disposito.");
		return mv;
	}
}