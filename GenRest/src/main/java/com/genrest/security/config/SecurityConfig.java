package com.genrest.security.config;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.web.servlet.ServletListenerRegistrationBean;
import org.springframework.context.annotation.Bean;
import org.springframework.security.config.annotation.authentication.builders.AuthenticationManagerBuilder;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.config.annotation.web.configuration.WebSecurityConfigurerAdapter;
import org.springframework.security.core.session.SessionRegistry;
import org.springframework.security.core.session.SessionRegistryImpl;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.web.authentication.session.RegisterSessionAuthenticationStrategy;
import org.springframework.security.web.authentication.session.SessionAuthenticationStrategy;
import org.springframework.security.web.session.HttpSessionEventPublisher;

import com.genrest.service.UsuarioService;


@EnableWebSecurity
public class SecurityConfig extends WebSecurityConfigurerAdapter {

	@Autowired
	private UsuarioService service;
		
	@Override
	protected void configure(HttpSecurity http) throws Exception {
		http.authorizeRequests()
			.antMatchers("/css/**", "/js/**", "/images/**").permitAll()	//autoriza pastas css, js, images e seus respectivos arquivos
			.antMatchers("/cadastrar", "/recuperar-senha", "/nova-senha", "/cadastrar-nova-senha", "/confirmacao", "/", "/expired").permitAll()
			.antMatchers("/conta/**").hasAnyAuthority("cadastrado", "pronto", "erro")
			.antMatchers("/dashboard/**").hasAuthority("pronto")
			.antMatchers("/api/**").hasAuthority("pronto")
			.antMatchers("/tokens/**").hasAuthority("pronto")
			.antMatchers("/logs/**").hasAuthority("pronto")
			.antMatchers("/clientes/**").hasAuthority("pronto")
			.anyRequest().authenticated()
			.and()
				.formLogin()
					.loginPage("/login")
					.usernameParameter("usuario")
					.passwordParameter("senha")
					.defaultSuccessUrl("/dashboard", true)
					.failureUrl("/login-error")
				.permitAll()
			.and()
				.logout()
				.logoutSuccessUrl("/login?logout")
				.logoutSuccessUrl("/login?naoAutenticado")
				.deleteCookies("JSESSIONID")
			.and()
				.exceptionHandling()
				.accessDeniedPage("/acesso-negado");
		http.csrf().disable();
		
		http.sessionManagement()
			.maximumSessions(1)
			.expiredUrl("/expired")
			.maxSessionsPreventsLogin(false)
			.sessionRegistry(sessionRegistry());
		
		http.sessionManagement()
			.sessionFixation().newSession()
			.sessionAuthenticationStrategy(sessionAuthStrategy());
	}

	@Override
	protected void configure(AuthenticationManagerBuilder auth) throws Exception {
		auth.userDetailsService(service).passwordEncoder(new BCryptPasswordEncoder());
	}
	
	@Bean
	SessionAuthenticationStrategy sessionAuthStrategy() {
		return new RegisterSessionAuthenticationStrategy(sessionRegistry());
	}
	
	@Bean
	public SessionRegistry sessionRegistry() {
		return new SessionRegistryImpl();
	}
	
	@Bean
	public ServletListenerRegistrationBean<?> serletListenerRegistrationBean(){
		return new ServletListenerRegistrationBean<>( new HttpSessionEventPublisher() );
	}
}