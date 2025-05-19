package com.genrest.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.genrest.repository.TokenRepository;
import com.genrest.service.DocService;
import com.genrest.service.UsuarioService;

import java.util.Arrays;
import java.util.List;

import com.genrest.model.Doc;
import com.genrest.model.Usuario;

@Controller
@RequestMapping("/api")

public class APIController {

	@Autowired TokenRepository repository;
	@Autowired UsuarioService usuarioService;

	@Autowired
	DocService service;
	
	@RequestMapping({"","/"})
	public ModelAndView api() {
		ModelAndView mv = new ModelAndView("api/Api");
		Usuario usuario = usuarioService.getUsuarioAutenticado();
		mv.addObject("qtdFuncoes", usuario.getQtdFuncoes());
		return mv;
	}

	@ModelAttribute("todosDados")
	public List<Doc> todosDados() {
		List<Doc> logs = service.getDocsByCliente();
		if (logs != null)
			return logs;

		return Arrays.asList();
	}
}
