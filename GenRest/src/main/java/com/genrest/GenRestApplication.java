package com.genrest;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

@SpringBootApplication
public class GenRestApplication {

	public static void main(String[] args) {
		SpringApplication.run(GenRestApplication.class, args);
		
		//System.out.println(new BCryptPasswordEncoder().encode("12345"));
	}
}