# Imobiliaria-Project
A PHP/MySQL project, simulating a real estate manager, registering customers, owners, properties and contracts.
---

<img src="./projeto_imobiliaria/gif/gif_principal.gif" title="Basic demonstrantion" alt="Basic demonstrantion"/>

This project was built with the challenge of developing a system that manages the basic functions of a real estate, being able to perform registrations, editions and deletions.
---

## Details
The project counts with some interesting details like:

- Registration interfaces, with fields validated by JQuery masks 

<img src="./projeto_imobiliaria/gif/gif_cadastro_cliente.gif" title="Client registration interface" alt="Client registration interface"/>

- Ability to edit customer, owner and property information

<img src="./projeto_imobiliaria/gif/gif_edicao.gif" title="Owner edition interface" alt="Owner edition interface"/>

- It's possible to have a contract, including a valid costumer CPF (previously registred) and a choosen property. After that, it's able to show all the details including the owner, property and costumer information.

<img src="./projeto_imobiliaria/gif/gif_contrato.gif" title="Contract interface" alt="Contract interface"/>

## Process Rules
Some rules must be followed for a logical performance, such as:

- Only a registered costumer can have a contract;
- Only a registered owner can have a property;
- Only a registered property can be leased;
- An owner cannot be removed if it's property is available;
- A property cannot be removed if it's included in a current contract, as well as a costumer;

This rules are part of the challenge, for the system and the database, but the system warns it everytime when necessary for a good experience.

Version: 1.0

Creation: 30/09/2019

*Everything made with a lot of curiosity and programming passion* 


