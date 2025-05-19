package com.genrest.controller;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.validation.Errors;
import org.springframework.validation.ObjectError;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.genrest.model.Token;
import com.genrest.repository.TokenRepository;
import com.genrest.service.TokenService;
import com.genrest.service.UsuarioService;

@Controller
@RequestMapping("/tokens")
public class TokenController {

	private static final String TOKEN = "api/Token";
	private static final String REDIRECT_TOKEN = "redirect:/tokens";

	@Autowired TokenRepository repository;
	@Autowired TokenService service;
	@Autowired UsuarioService usuarioService;
	
	@RequestMapping({"", "/"})
	public ModelAndView tokens() {
		ModelAndView mv = new ModelAndView(TOKEN);
		mv.addObject(new Token());
		return mv;
	}
	
	@PostMapping("/cadastrar")
	public ModelAndView cadastrar(@Validated Token token, Errors erros, RedirectAttributes attributes){
		ModelAndView mv = new ModelAndView(REDIRECT_TOKEN);
		List<String> listaErros = new ArrayList<>();
		if(erros.hasErrors()) {
			for (ObjectError erro : erros.getAllErrors()) {
				listaErros.add(erro.getDefaultMessage());
			}
			attributes.addFlashAttribute("listaErros", listaErros);
			return mv;
		}

		if(service.tokenExiste(token)) {
			attributes.addFlashAttribute("classe", "alert alert-danger");
			attributes.addFlashAttribute("mensagem", "Usuário "+ token.getUsuario() +" já existe!");
			return mv;
		}
		
		token = service.cadastrar(token);
		attributes.addFlashAttribute("hash", token.getHash());
		attributes.addFlashAttribute("classe", "alert alert-success");
		attributes.addFlashAttribute("mensagem", "Token adicionado com sucesso!");
		return mv;
	}
	
	@RequestMapping("/delete/{usuarioId}")
	public ModelAndView excluir(@PathVariable Long usuarioId, RedirectAttributes attributes) {
		ModelAndView mv = new ModelAndView(REDIRECT_TOKEN);
		if(!repository.existsById(usuarioId)){
			attributes.addFlashAttribute("classe","alert alert-danger");
			attributes.addFlashAttribute("mensagem", "token não existe!");
			return mv;
		}
		service.excluir(usuarioId);
		attributes.addFlashAttribute("classe", "alert alert-success");
		attributes.addFlashAttribute("mensagem", "Token excluído com sucesso!");
		return mv;
	}
	
	@ModelAttribute("todosTokens")
	public List<Token> todosTokens() {
		List<Token> tokens = repository.findByClienteId(usuarioService.getUsuarioAutenticado().getId());
		if(tokens != null)
			return tokens;
		
		return Arrays.asList();
	}
}
