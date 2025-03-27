// lib/presentation/screens/register_screen.dart

import 'package:buzosmt/Domains/models/user_model.dart';
import 'package:buzosmt/Domains/usecases/register_user.dart';
import 'package:flutter/material.dart';
import '../../Domains/models/user_model.dart';
import '../../Domains/usecases/register_user.dart';
import '../../Data/repositories/user_repository.dart';
import 'login_screen.dart'; // Importa la pantalla de login

// Define a placeholder LoginScreen class if it doesn't exist


class RegisterScreen extends StatefulWidget {
  @override
  _RegisterScreenState createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _formKey = GlobalKey<FormState>();
  final _userRepository = UserRepositoryImpl();
  final _registerUser = RegisterUser();

  final _tDocController = TextEditingController();
  final _numDocController = TextEditingController();
  final _usuNombresController = TextEditingController();
  final _usuApellidosController = TextEditingController();
  final _usuFechaNacimientoController = TextEditingController();
  final _usuSexoController = TextEditingController();
  final _usuTelefonoController = TextEditingController();
  final _usuEmailController = TextEditingController();
  final _passwordController = TextEditingController();
  final _passwordConfirmationController = TextEditingController();

  Future<void> _selectDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: DateTime.now(),
      firstDate: DateTime(1900),
      lastDate: DateTime.now(),
    );
    if (picked != null) {
      setState(() {
        _usuFechaNacimientoController.text = "${picked.toLocal()}".split(' ')[0];
      });
    }
  }

  bool _isValidDate(String input) {
    try {
      final DateTime date = DateTime.parse(input);
      return true;
    } catch (e) {
      return false;
    }
  }

  void _submitForm(BuildContext context) {
    if (_formKey.currentState!.validate()) {
      final user = User(
        tDoc: _tDocController.text,
        numDoc: _numDocController.text,
        usuNombres: _usuNombresController.text,
        usuApellidos: _usuApellidosController.text,
        usuFechaNacimiento: _usuFechaNacimientoController.text,
        usuSexo: _usuSexoController.text,
        usuTelefono: _usuTelefonoController.text,
        usuEmail: _usuEmailController.text,
        password: _passwordController.text,
        passwordConfirmation: _passwordConfirmationController.text,
      );

      // Mostrar los datos en la terminal
      print('Datos del usuario registrado:');
      print('Tipo de Documento: ${user.tDoc}');
      print('Número de Documento: ${user.numDoc}');
      print('Nombres: ${user.usuNombres}');
      print('Apellidos: ${user.usuApellidos}');
      print('Fecha de Nacimiento: ${user.usuFechaNacimiento}');
      print('Sexo: ${user.usuSexo}');
      print('Teléfono: ${user.usuTelefono}');
      print('Correo Electrónico: ${user.usuEmail}');
      print('Contraseña: ${user.password}');

      // Llamar al caso de uso para registrar al usuario
      _registerUser.call(user);

      // Navegar a la pantalla de login
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => Login()),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          Container(
            height: double.infinity,
            width: double.infinity,
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                colors: [
                  Color.fromARGB(255, 15, 52, 67),
                  Color.fromARGB(255, 52, 230, 159),
                ],
              ),
            ),
            child: const Padding(
              padding: EdgeInsets.only(top: 60.0, left: 22),
              child: Text(
                'Registro\nUsuario',
                style: TextStyle(
                  fontSize: 30,
                  color: Colors.white,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.only(top: 200.0),
            child: Container(
              decoration: const BoxDecoration(
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(40),
                  topRight: Radius.circular(40),
                ),
                color: Colors.white,
              ),
              height: double.infinity,
              width: double.infinity,
              child: Padding(
                padding: const EdgeInsets.symmetric(horizontal: 25.0, vertical: 20.0),
                child: Form(
                  key: _formKey,
                  child: ListView(
                    padding: EdgeInsets.only(top: 20),
                    children: [
                      DropdownButtonFormField<String>(
                        items: ['CC', 'PPT', 'TI'].map((String value) {
                          return DropdownMenuItem<String>(
                            value: value,
                            child: Text(value),
                          );
                        }).toList(),
                        onChanged: (value) {
                          _tDocController.text = value!;
                        },
                        decoration: InputDecoration(
                          prefixIcon: Icon(Icons.badge),
                          labelText: 'Tipo de Documento',
                          labelStyle: TextStyle(
                            fontWeight: FontWeight.bold,
                            color: Color.fromARGB(255, 15, 52, 67),
                          ),
                          contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                        ),
                      ),
                      SizedBox(height: 20),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_numDocController.text.isNotEmpty &&
                              !RegExp(r'^[0-9]+$').hasMatch(_numDocController.text))
                            Text(
                              'El número de documento solo debe contener números',
                              style: TextStyle(color: Colors.red, fontSize: 12),
                            ),
                          TextFormField(
                            controller: _numDocController,
                            decoration: InputDecoration(
                              prefixIcon: Icon(Icons.numbers),
                              labelText: 'Número de Documento',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color.fromARGB(255, 15, 52, 67),
                              ),
                              contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                            ),
                            keyboardType: TextInputType.number,
                            onChanged: (value) {
                              setState(() {});
                            },
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor ingrese su número de documento';
                              }
                              if (!RegExp(r'^[0-9]+$').hasMatch(value)) {
                                return 'El número de documento solo debe contener números';
                              }
                              return null;
                            },
                          ),
                        ],
                      ),
                      SizedBox(height: 20),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_usuNombresController.text.isNotEmpty &&
                              !RegExp(r'^[a-zA-Z\s]+$').hasMatch(_usuNombresController.text))
                            Text(
                              'Solo se permiten letras y espacios',
                              style: TextStyle(color: Colors.red, fontSize: 12),
                            ),
                          TextFormField(
                            controller: _usuNombresController,
                            decoration: InputDecoration(
                              prefixIcon: Icon(Icons.person),
                              labelText: 'Nombres',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color.fromARGB(255, 15, 52, 67),
                              ),
                              contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                            ),
                            onChanged: (value) {
                              setState(() {});
                            },
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Este campo es obligatorio';
                              }
                              if (!RegExp(r'^[a-zA-Z\s]+$').hasMatch(value)) {
                                return 'Solo se permiten letras y espacios';
                              }
                              return null;
                            },
                          ),
                        ],
                      ),
                      SizedBox(height: 20),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_usuApellidosController.text.isNotEmpty &&
                              !RegExp(r'^[a-zA-Z\s]+$').hasMatch(_usuApellidosController.text))
                            Text(
                              'Solo se permiten letras y espacios',
                              style: TextStyle(color: Colors.red, fontSize: 12),
                            ),
                          TextFormField(
                            controller: _usuApellidosController,
                            decoration: InputDecoration(
                              prefixIcon: Icon(Icons.person_outline),
                              labelText: 'Apellidos',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color.fromARGB(255, 15, 52, 67),
                              ),
                              contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                            ),
                            onChanged: (value) {
                              setState(() {});
                            },
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor ingrese sus apellidos';
                              }
                              if (!RegExp(r'^[a-zA-Z\s]+$').hasMatch(value)) {
                                return 'Solo se permiten letras y espacios';
                              }
                              return null;
                            },
                          ),
                        ],
                      ),
                      SizedBox(height: 20),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_usuFechaNacimientoController.text.isNotEmpty &&
                              !_isValidDate(_usuFechaNacimientoController.text))
                            Text(
                              'Formato de fecha inválido (YYYY-MM-DD)',
                              style: TextStyle(color: Colors.red, fontSize: 12),
                            ),
                          TextFormField(
                            controller: _usuFechaNacimientoController,
                            decoration: InputDecoration(
                              prefixIcon: Icon(Icons.calendar_today),
                              labelText: 'Fecha de Nacimiento (YYYY-MM-DD)',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color.fromARGB(255, 15, 52, 67),
                              ),
                              contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                              suffixIcon: IconButton(
                                icon: Icon(Icons.calendar_today),
                                onPressed: () => _selectDate(context),
                              ),
                            ),
                            readOnly: true,
                            onChanged: (value) {
                              setState(() {});
                            },
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Este campo es obligatorio';
                              }
                              if (!_isValidDate(value)) {
                                return 'Formato de fecha inválido (YYYY-MM-DD)';
                              }
                              return null;
                            },
                          ),
                        ],
                      ),
                      SizedBox(height: 20),
                      DropdownButtonFormField<String>(
                        items: ['M', 'F'].map((String value) {
                          return DropdownMenuItem<String>(
                            value: value,
                            child: Text(value),
                          );
                        }).toList(),
                        onChanged: (value) {
                          _usuSexoController.text = value!;
                        },
                        decoration: InputDecoration(
                          prefixIcon: Icon(Icons.person_outlined),
                          labelText: 'Sexo',
                          labelStyle: TextStyle(
                            fontWeight: FontWeight.bold,
                            color: Color.fromARGB(255, 15, 52, 67),
                          ),
                          contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                        ),
                      ),
                      SizedBox(height: 20),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_usuTelefonoController.text.isNotEmpty &&
                              (_usuTelefonoController.text.length != 10 ||
                                  !RegExp(r'^[0-9]+$').hasMatch(_usuTelefonoController.text)))
                            Text(
                              'El teléfono debe tener exactamente 10 dígitos',
                              style: TextStyle(color: Colors.red, fontSize: 12),
                            ),
                          TextFormField(
                            controller: _usuTelefonoController,
                            decoration: InputDecoration(
                              prefixIcon: Icon(Icons.phone),
                              labelText: 'Teléfono',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color.fromARGB(255, 15, 52, 67),
                              ),
                              contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                            ),
                            keyboardType: TextInputType.phone,
                            onChanged: (value) {
                              setState(() {});
                            },
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor ingrese su teléfono';
                              }
                              if (value.length != 10 || !RegExp(r'^[0-9]+$').hasMatch(value)) {
                                return 'El teléfono debe tener exactamente 10 dígitos';
                              }
                              return null;
                            },
                          ),
                        ],
                      ),
                      SizedBox(height: 20),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_usuEmailController.text.isNotEmpty &&
                              !RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$').hasMatch(_usuEmailController.text))
                            Text(
                              'Ingrese un correo electrónico válido',
                              style: TextStyle(color: Colors.red, fontSize: 12),
                            ),
                          TextFormField(
                            controller: _usuEmailController,
                            decoration: InputDecoration(
                              prefixIcon: Icon(Icons.email),
                              labelText: 'Correo Electrónico',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color.fromARGB(255, 15, 52, 67),
                              ),
                              contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                            ),
                            keyboardType: TextInputType.emailAddress,
                            onChanged: (value) {
                              setState(() {});
                            },
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor ingrese su correo electrónico';
                              }
                              if (!RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$').hasMatch(value)) {
                                return 'Ingrese un correo electrónico válido';
                              }
                              return null;
                            },
                          ),
                        ],
                      ),
                      SizedBox(height: 20),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_passwordController.text.isNotEmpty &&
                              !RegExp(r'^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#\$&*~]).{8,}$').hasMatch(_passwordController.text))
                            Text(
                              'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial',
                              style: TextStyle(color: Colors.red, fontSize: 12),
                            ),
                          TextFormField(
                            controller: _passwordController,
                            decoration: InputDecoration(
                              prefixIcon: Icon(Icons.lock),
                              labelText: 'Contraseña',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color.fromARGB(255, 15, 52, 67),
                              ),
                              contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                            ),
                            obscureText: true,
                            onChanged: (value) {
                              setState(() {});
                            },
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Este campo es obligatorio';
                              }
                              if (!RegExp(r'^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#\$&*~]).{8,}$').hasMatch(value)) {
                                return 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial';
                              }
                              return null;
                            },
                          ),
                        ],
                      ),
                      SizedBox(height: 20),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_passwordConfirmationController.text.isNotEmpty &&
                              _passwordConfirmationController.text != _passwordController.text)
                            Text(
                              'Las contraseñas no coinciden',
                              style: TextStyle(color: Colors.red, fontSize: 12),
                            ),
                          TextFormField(
                            controller: _passwordConfirmationController,
                            decoration: InputDecoration(
                              prefixIcon: Icon(Icons.lock_outline),
                              labelText: 'Confirmación de Contraseña',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color.fromARGB(255, 15, 52, 67),
                              ),
                              contentPadding: EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                            ),
                            obscureText: true,
                            onChanged: (value) {
                              setState(() {});
                            },
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Por favor confirme su contraseña';
                              }
                              if (value != _passwordController.text) {
                                return 'Las contraseñas no coinciden';
                              }
                              return null;
                            },
                          ),
                        ],
                      ),
                      SizedBox(height: 30),
                      Container(
                        height: 55,
                        width: double.infinity,
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(30),
                          color: Color.fromARGB(255, 15, 52, 67),
                        ),
                        child: ElevatedButton(
                          style: ElevatedButton.styleFrom(
                            backgroundColor: Colors.transparent,
                            shadowColor: Colors.transparent,
                          ),
                          onPressed: () {
                            _submitForm(context); // Llamar a la función para enviar el formulario
                          },
                          child: Text(
                            'Registrar',
                            style: TextStyle(
                              fontWeight: FontWeight.bold,
                              fontSize: 20,
                              color: Colors.white,
                            ),
                          ),
                        ),
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