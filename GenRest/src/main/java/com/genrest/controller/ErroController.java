package com.genrest.controller;

import javax.servlet.RequestDispatcher;
import javax.servlet.http.HttpServletRequest;

import org.springframework.boot.web.servlet.error.ErrorController;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

@Controller
public class ErroController implements ErrorController {
    
    @RequestMapping("/error")
    public ModelAndView handleError(HttpServletRequest request){
		ModelAndView mv = new ModelAndView("error");
        //Objeto status para filtrar mensagem de erro por status (caso necessário)
		Object status = request.getAttribute(RequestDispatcher.ERROR_STATUS_CODE);		
		String mensagem = "";
		
		if (status != null) {
	        Integer statusCode = Integer.valueOf(status.toString());
	        if(statusCode == HttpStatus.NOT_FOUND.value()) {
	        	mensagem = "Não foi possível acessar o endereço: " + request.getAttribute(RequestDispatcher.ERROR_REQUEST_URI).toString();
	        }
	        else if(statusCode == HttpStatus.INTERNAL_SERVER_ERROR.value()) {
	        	mensagem = "Erro interno, contate o administrador. " + request.getAttribute(RequestDispatcher.ERROR_MESSAGE).toString();
	        } else {
	        	mensagem = request.getAttribute(RequestDispatcher.ERROR_MESSAGE).toString();
	        }
	    }
		mv.addObject("status", status);
		mv.addObject("mensagem", mensagem);
		return mv;
    }
}
