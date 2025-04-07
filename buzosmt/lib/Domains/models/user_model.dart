import 'dart:convert';
import 'package:buzosmt/Data/DataSources/remote/Login_remote.dart';

class User {
  final int? tDoc;
  final String numDoc;
  final String? usuNombres;
  final String? usuApellidos;
  final String? usuFechaNacimiento;
  final String? usuSexo;
  final String? usuTelefono;
  final String? usuEmail;
  final String password;
  final String? passwordConfirmation;
  final int usuEstado;

  // Constructor principal
  User({
    required this.tDoc,
    required this.numDoc,
    this.usuNombres,
    this.usuApellidos,
    this.usuFechaNacimiento,
    this.usuSexo,
    this.usuTelefono,
    this.usuEmail,
    required this.password,
    this.passwordConfirmation,
    this.usuEstado = 1,
  });

  Future <Map<String, dynamic>> jsonForLogin() async {
    final Map<String, dynamic> user = {
      't_doc': tDoc,
      'num_doc': numDoc,
      'password': password,
    };
    final String data = jsonEncode(user);
    Login login = Login();
    final status = await login.apiLogin(data);
    return status;
  }
}
