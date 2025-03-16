import 'package:flutter/material.dart';

class Login extends StatefulWidget {
  const Login({super.key});
  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  String email = '';
  String password = '';

  login(String email, String password) {
    print('Email: $email');
    print('Password: $password');
     
    }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Login')),
      body: ListView(
        children: [
          ListTile(
            title: TextField(
              controller: emailController,
              decoration: InputDecoration(labelText: 'Email'),
            ),
          ),
          ListTile(
            title: TextField(
              controller: passwordController,
              decoration: InputDecoration(labelText: 'Contaseña'),
            ),
          ),
        ],
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () {
          login(emailController.text, passwordController.text);
        },
        child: Text('ingresar'),
      ),
    );
  }
}
