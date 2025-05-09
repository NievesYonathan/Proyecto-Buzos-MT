import 'dart:convert';
import '../../Data/repositories/user_repository.dart';

class User {
  final int? tDoc;
  final String? numDoc;
  final String? usuNombres;
  final String? usuApellidos;
  final String? usuFechaNacimiento;
  final String? usuSexo;
  final String? usuTelefono;
  final String? usuEmail;
  final String? password;
  final String? passwordConfirmation;
  final String? usuDireccion;
  final int usuEstado;

  // Constructor principal
  User({
    this.tDoc,
    this.numDoc,
    this.usuNombres,
    this.usuApellidos,
    this.usuFechaNacimiento,
    this.usuSexo,
    this.usuTelefono,
    this.usuEmail,
    this.password,
    this.passwordConfirmation,
    this.usuEstado = 1,
    this.usuDireccion
  });

  Future<Map<String, dynamic>> jsonForLogin() async {
    final Map<String, dynamic> user = {
      't_doc': tDoc,
      'num_doc': numDoc,
      'password': password,
    };
    final String data = jsonEncode(user);
    UserRepository login = UserRepository();
    final status = await login.apiLogin(data);
    return status;
  }

  Future<Map<String, dynamic>> jsonForRegister() async {
    final Map<String, dynamic> user = {
      't_doc': tDoc,
      'num_doc': numDoc,
      'usu_nombres': usuNombres,
      'usu_apellidos': usuApellidos,
      'usu_fecha_nacimiento': usuFechaNacimiento,
      'usu_sexo': usuSexo,
      'usu_telefono': usuTelefono,
      'email': usuEmail,
      'usu_estado': usuEstado,
      'password': password,
      'password_confirmation': passwordConfirmation,
      'usu_direccion': usuDireccion
    };

    final String data = jsonEncode(user);
    UserRepository register = UserRepository();
    final status = await register.apiRegister(data);
    return status;
  }

  Future<Map<String, dynamic>> jsonForPassword() async {
    final Map<String, dynamic> user = {'email': usuEmail};
    final String data = jsonEncode(user);
    UserRepository resetPassword = UserRepository();
    final status = await resetPassword.resetPassword(data);
    return status;
  }
}
