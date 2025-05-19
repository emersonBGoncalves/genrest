package com.genrest.service;

import java.time.Instant;
import java.util.UUID;
import java.util.function.Supplier;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import com.genrest.model.Token;
import com.genrest.repository.TokenRepository;

@Service
public class TokenService {

	@Autowired
	TokenRepository repository;
	@Autowired
	UsuarioService usuarioService;
	
	public Token cadastrar(Token request) {
		String tokenTemp = getToken();
		request.setClienteId(usuarioService.getUsuarioAutenticado().getId());
		request.setHash(new BCryptPasswordEncoder().encode(tokenTemp));
		Token response = repository.save(request);
		response.setHash(tokenTemp);
		return response;
	}
	
	@Transactional(readOnly = false)
	public void excluir(Long id) {
		repository.deleteById(id);
	}

	@Transactional(readOnly = true)
	public boolean tokenExiste(Token token) {
		Token tokenTemp = repository.findByUsuarioAndClienteId(token.getUsuario()
				, usuarioService.getUsuarioAutenticado().getId());
		if(tokenTemp != null)
			return true;
		return false;
	}
	
	private String getToken() {
		Supplier<String> tokenSupplier = () -> {
			StringBuilder token = new StringBuilder();
			long currentTimeInMilisecond = Instant.now().toEpochMilli();
			return token.append(currentTimeInMilisecond).append("-")
					.append(UUID.randomUUID().toString()).toString();
		};
		return tokenSupplier.get();
	}

}
