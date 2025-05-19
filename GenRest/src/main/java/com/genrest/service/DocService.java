package com.genrest.service;

import com.genrest.model.Doc;
import com.genrest.repository.DocRepository;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class DocService {

	@Autowired
	DocRepository repository;

	@Autowired
	UsuarioService usuarioService;

	public List<Doc> getDocsByCliente() {
		return repository.findByClienteId(usuarioService.getUsuarioAutenticado().getId());
	}
}
