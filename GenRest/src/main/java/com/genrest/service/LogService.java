package com.genrest.service;

import com.genrest.model.Log;
import com.genrest.model.Usuario;
import com.genrest.repository.LogRepository;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service
public class LogService {
    
    @Autowired LogRepository repository;
    @Autowired UsuarioService usuarioService;

    @Transactional(readOnly = true)
    public List<Log> getUsoPorHora(){
        Usuario usuario = usuarioService.getUsuarioAutenticado();
        List<Log> lista = repository.getUsoHora(usuario.getId());
        return lista;
    }
    
    @Transactional(readOnly = true)
    public List<Log> getUsoPorMes(){
    	Usuario usuario = usuarioService.getUsuarioAutenticado();
        List<Log> lista = repository.getUsoMes(usuario.getId());
        return lista;
    }
    
    @Transactional(readOnly = true)
    public List<Log> getUsoPorUsuarioDia(){
    	Usuario usuario = usuarioService.getUsuarioAutenticado();
        List<Log> lista = repository.getUsuariosDia(usuario.getId());
        return lista;
    }
    
    @Transactional(readOnly = true)
    public List<Log> getUsoPorUsuarioMes(){
    	Usuario usuario = usuarioService.getUsuarioAutenticado();
        List<Log> lista = repository.getUsuariosMes(usuario.getId());
        return lista;
    }

    @Transactional(readOnly = true)
    public List<Log> getLogsByCliente() {
        return repository.findByClienteId(usuarioService.getUsuarioAutenticado().getId());
    }
    
    @Transactional(readOnly = true)
    public long getQtdRequisicoes() {
        Usuario usuario = usuarioService.getUsuarioAutenticado();
        long qtd = repository.getQtdRequisicoes(usuario.getId());
        return qtd;
    }
}
