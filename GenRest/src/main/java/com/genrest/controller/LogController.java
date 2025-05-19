package com.genrest.controller;

import java.util.Arrays;
import java.util.List;

import com.genrest.model.Log;
import com.genrest.repository.LogRepository;
import com.genrest.service.LogService;
import com.genrest.service.UsuarioService;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

@Controller
@RequestMapping("/logs")
public class LogController {
    
    private static final String LOG = "api/Log";
	//private static final String REDIRECT_LOG = "redirect:/logs";

    @Autowired
    LogRepository repository;

	@Autowired
    LogService service;

    @Autowired
    UsuarioService usuarioService;

    @RequestMapping({"", "/"})
	public ModelAndView tokens() {
		ModelAndView mv = new ModelAndView(LOG);
		return mv;
	}

    @ModelAttribute("todosLogs")
	public List<Log> todosLogs() {
		List<Log> logs = service.getLogsByCliente();
		if(logs != null)
			return logs;
		
		return Arrays.asList();
	}
}
