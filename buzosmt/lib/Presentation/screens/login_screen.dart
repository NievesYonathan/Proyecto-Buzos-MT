import 'package:flutter/material.dart';

class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final TextEditingController numDocController = TextEditingController();
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  final _formKey = GlobalKey<FormState>();

  void login() {
    if (_formKey.currentState!.validate()) {
      setState(() {}); // Refresca la UI antes de mostrar la alerta

      // Espera un pequeño tiempo para evitar problemas con `context`
      Future.delayed(Duration(milliseconds: 100), () {
        mostrarAlerta();
      });
    }
  }

  void mostrarAlerta() {
    showDialog(
      context: context,
      barrierDismissible: false, // Evita que se cierre tocando fuera
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text("Registro Exitoso ✅"),
          content: Text("El usuario ha sido registrado con éxito."),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context); // Cierra la alerta
              },
              child: Text("OK"),
            ),
          ],
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          Container(
            height: double.infinity,
            width: double.infinity,
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [
                  Color(0xFF12464C),
                  Color(0xFF34E69F),
                ],
              ),
            ),
            child: Padding(
              padding: EdgeInsets.only(top: 10.0, left: 10.0),
              child: Text(
                'Hola,\nBienvenido!',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                  color: Colors.white,
                ),
              ),
            ),
          ),
          Padding(
            padding: EdgeInsets.only(top: 200.0),
            child: Container(
              height: 400,
              width: double.infinity,
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(30),
                  topRight: Radius.circular(30),
                ),
              ),
              child: Form(
                key: _formKey,
                child: Padding(
                  padding: EdgeInsets.symmetric(horizontal: 18.0, vertical: 30.0),
                  child: Column(
                    children: [
                      DropdownButtonFormField<String>(
                        items: ['CC', 'TI', 'CE'].map((String value) {
                          return DropdownMenuItem<String>(
                            value: value,
                            child: Text(value),
                          );
                        }).toList(),
                        onChanged: (value) {
                          numDocController.text = value!;
                        },
                        decoration: InputDecoration(
                          labelText: 'Tipo de Documento',
                          prefixIcon: Icon(Icons.badge),
                        ),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Por favor seleccione un tipo de documento';
                          }
                          return null;
                        },
                      ),
                      SizedBox(height: 10),
                      TextFormField(
                        controller: emailController,
                        decoration: InputDecoration(
                          labelText: 'Número de Documento',
                          prefixIcon: Icon(Icons.person),
                        ),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Por favor ingrese un número de documento';
                          }
                          return null;
                        },
                      ),
                      SizedBox(height: 10),
                      TextFormField(
                        controller: passwordController,
                        decoration: InputDecoration(
                          labelText: 'Contraseña',
                          prefixIcon: Icon(Icons.lock),
                        ),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Por favor ingrese una contraseña';
                          }
                          return null;
                        },
                        obscureText: true,
                      ),
                      SizedBox(height: 20),
                      ElevatedButton(
                        onPressed: login,
                        child: Text('Registrarse'),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
