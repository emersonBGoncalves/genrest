package com.genrest.controller;

import java.util.ArrayList;
import java.util.List;

import com.genrest.model.Permissao;
import com.genrest.model.Usuario;
import com.genrest.service.UsuarioService;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.bind.annotation.ModelAttribute;

@ControllerAdvice
public class GlobalController {
    
    @Autowired
    UsuarioService usuarioService;

    @ModelAttribute
    public String atualizaPermissoes(){
        Object authorities = SecurityContextHolder.getContext().getAuthentication().getPrincipal();
        if (authorities instanceof UserDetails) {
            Usuario usuario = usuarioService.getUsuarioAutenticado(); //busca usuario autenticado
            List<SimpleGrantedAuthority> updatedAuthorities = new ArrayList<SimpleGrantedAuthority>(); //array de permissoes
            //percorre permissoes do usuario e adiciona na lista de permissoes
            for (Permissao permissao : usuario.getPermissoes()){
                SimpleGrantedAuthority authority = new SimpleGrantedAuthority(permissao.getDesc());
                updatedAuthorities.add(authority);
            } 

            //efetiva permissoes do usuario
            SecurityContextHolder.getContext().setAuthentication(
                    new UsernamePasswordAuthenticationToken(
                            SecurityContextHolder.getContext().getAuthentication().getPrincipal(),
                            SecurityContextHolder.getContext().getAuthentication().getCredentials(),
                            updatedAuthorities)
            );
		}
        return null;
    }

    @ModelAttribute("usuarioLogado")
    public Usuario getUsuario(){
        Usuario usuario = usuarioService.getUsuarioAutenticado();
        if(usuario != null)
            return usuario;
        return null;
    }
}
