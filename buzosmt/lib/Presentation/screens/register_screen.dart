// lib/presentation/screens/register_screen.dart

import 'package:flutter/material.dart';
import '../../Domains/models/user_model.dart';
import '../../Domains/usecases/register_user.dart';
import '../../data/repositories/user_repository.dart';

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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Registro de Usuario'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: ListView(
            children: [
              DropdownButtonFormField<String>(
                value: 'CC',
                items: ['CC', 'TI', 'CE'].map((String value) {
                  return DropdownMenuItem<String>(
                    value: value,
                    child: Text(value),
                  );
                }).toList(),
                onChanged: (value) {
                  _tDocController.text = value!;
                },
                decoration: InputDecoration(labelText: 'Tipo de Documento'),
              ),
              TextFormField(
                controller: _numDocController,
                decoration: InputDecoration(labelText: 'Número de Documento'),
                keyboardType: TextInputType.number,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese su número de documento';
                  }
                  return null;
                },
              ),
              TextFormField(
                controller: _usuNombresController,
                decoration: InputDecoration(labelText: 'Nombres'),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese sus nombres';
                  }
                  return null;
                },
              ),
              TextFormField(
                controller: _usuApellidosController,
                decoration: InputDecoration(labelText: 'Apellidos'),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese sus apellidos';
                  }
                  return null;
                },
              ),
              TextFormField(
                controller: _usuFechaNacimientoController,
                decoration: InputDecoration(labelText: 'Fecha de Nacimiento (YYYY-MM-DD)'),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese su fecha de nacimiento';
                  }
                  return null;
                },
              ),
              DropdownButtonFormField<String>(
                value: 'M',
                items: ['M', 'F', 'O'].map((String value) {
                  return DropdownMenuItem<String>(
                    value: value,
                    child: Text(value),
                  );
                }).toList(),
                onChanged: (value) {
                  _usuSexoController.text = value!;
                },
                decoration: InputDecoration(labelText: 'Sexo'),
              ),
              TextFormField(
                controller: _usuTelefonoController,
                decoration: InputDecoration(labelText: 'Teléfono'),
                keyboardType: TextInputType.phone,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese su teléfono';
                  }
                  return null;
                },
              ),
              TextFormField(
                controller: _usuEmailController,
                decoration: InputDecoration(labelText: 'Correo Electrónico'),
                keyboardType: TextInputType.emailAddress,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese su correo electrónico';
                  }
                  return null;
                },
              ),
              TextFormField(
                controller: _passwordController,
                decoration: InputDecoration(labelText: 'Contraseña'),
                obscureText: true,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor ingrese su contraseña';
                  }
                  return null;
                },
              ),
              TextFormField(
                controller: _passwordConfirmationController,
                decoration: InputDecoration(labelText: 'Confirmación de Contraseña'),
                obscureText: true,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Por favor confirme su contraseña';
                  }
                  return null;
                },
              ),
              SizedBox(height: 20),
              ElevatedButton(
                onPressed: () {
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
                    _registerUser.call(user);
                  }
                },
                child: Text('Registrar'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}