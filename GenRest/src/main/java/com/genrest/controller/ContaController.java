package com.genrest.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.validation.Errors;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.genrest.model.Usuario;
import com.genrest.repository.TokenRepository;
import com.genrest.service.UsuarioService;

@Controller
@RequestMapping("/conta")
public class ContaController {

	@Autowired
	TokenRepository repository;
	@Autowired
	UsuarioService usuarioService;

	@RequestMapping({"","/"})
	public ModelAndView conta() {
		ModelAndView mv = new ModelAndView("conta/Conta");
		Usuario usuario = usuarioService.getUsuarioAutenticado();
		mv.addObject("usuario", usuario);
		mv.addObject("permissao", usuario.getPermissoes().get(0).getId());
		return mv;
	}


	@RequestMapping("/gravar")
	public ModelAndView gravar(@Validated Usuario usuario, Errors error, RedirectAttributes attributes) {
		ModelAndView mv = new ModelAndView("conta/Conta");
		if(error.hasErrors()){
			return mv;
		}
		if(!usuarioService.salvarConta(usuario)) {
			mv.addObject("erro", true);
			return mv;
		}
		mv.setViewName("redirect:/conta");
		attributes.addFlashAttribute("sucesso", true);
		return mv;
	}

}
