package com.genrest.service;

import javax.mail.MessagingException;
import javax.mail.internet.MimeMessage;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;
import org.thymeleaf.context.Context;
import org.thymeleaf.spring5.SpringTemplateEngine;

@Service
public class EmailService {

	@Autowired
	private JavaMailSender mailSender;
	@Autowired
	private SpringTemplateEngine template;
	
	MimeMessage message;
	MimeMessageHelper helper;
	Context context;
	
	private void preparaEmail(String destino) throws MessagingException {
		message = mailSender.createMimeMessage();
		helper = new MimeMessageHelper(message, MimeMessageHelper.MULTIPART_MODE_MIXED_RELATED, "UTF-8");
		context = new Context();
		helper.setTo(destino);
		helper.setFrom("nao-responda@genrest.com");
	}
	
	public void enviarPedidoDeConfirmacaoDeCadastro(String destino, Long token) throws MessagingException {
		preparaEmail(destino);
		context.setVariable("token", token);
		String html = template.process("email/LayoutConfirmacaoEmail", context);
		helper.setText(html, true);
		helper.setSubject("GenRest - Confirmação de E-mail");
		mailSender.send(message);
	}
	
	public void enviarRecuperacaoSenha(String destino, Long token) throws MessagingException {
		preparaEmail(destino);
		context.setVariable("token", token);
		String html = template.process("email/LayoutRecuperacaoSenha", context);
		helper.setText(html, true);
		helper.setSubject("GenRest - Recuperação de Senha");
		mailSender.send(message);
	}
}
