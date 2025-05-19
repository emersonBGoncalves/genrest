package com.genrest.controller;

import java.text.DecimalFormat;

import com.genrest.model.Usuario;
import com.genrest.service.LogService;
import com.genrest.service.UsuarioService;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

@Controller
public class DashboardController {

    @Autowired
    LogService logService;        

    @Autowired
    UsuarioService usuarioService;
    //carrega página de dashboard
    @RequestMapping({"/dashboard"})
    public ModelAndView inicio() {
		if(usuarioService.getUsuarioAutenticado().getVerificado() == 0) {
			ModelAndView mv = new ModelAndView("redirect:/login?naoAutenticado");
			return mv;
		}

        ModelAndView mv = new ModelAndView("usuario/Dashboard");
        mv.addObject("listaUsoHora", logService.getUsoPorHora());
        mv.addObject("listaUsoMes", logService.getUsoPorMes());
        mv.addObject("listaUsoUsuariosDia", logService.getUsoPorUsuarioDia());
        mv.addObject("listaUsoUsuariosMes", logService.getUsoPorUsuarioMes());

        Long qtdRequisicoes = logService.getQtdRequisicoes();
        mv.addObject("QtdRequisicoes", qtdRequisicoes);

        Usuario usuario = usuarioService.getUsuarioAutenticado();

        int plano_atual = usuario.getPlano();
        
        DecimalFormat df = new DecimalFormat();
        df.setMaximumFractionDigits(2);

        if(plano_atual == 1) {
            mv.addObject("planoAtual", "Pagamento Mensal");
            mv.addObject("ValorQtdRequisicoes", "R$ ".concat(df.format(qtdRequisicoes * 0.05)));
        }
        else if(plano_atual == 2) {
            mv.addObject("planoAtual", "Pagamento Semestral");
            mv.addObject("ValorQtdRequisicoes", "R$ ".concat(df.format(qtdRequisicoes * 0.07)));
        }
        else {
            mv.addObject("planoAtual", "Pagamento Anual");
            mv.addObject("ValorQtdRequisicoes", "R$ ".concat(df.format(qtdRequisicoes * 0.10)));
        }
        mv.addObject("qtdFuncoes", usuario.getQtdFuncoes());
        return mv;
    }
    
}