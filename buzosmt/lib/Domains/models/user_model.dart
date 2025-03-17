// lib/domain/models/user_model.dart

class User {
  final String tDoc;
  final String numDoc;
  final String usuNombres;
  final String usuApellidos;
  final String usuFechaNacimiento;
  final String usuSexo;
  final String usuTelefono;
  final String usuEmail;
  final String password;
  final String passwordConfirmation;
  final int usuEstado;
  final String usuDireccion;

  User({
    required this.tDoc,
    required this.numDoc,
    required this.usuNombres,
    required this.usuApellidos,
    required this.usuFechaNacimiento,
    required this.usuSexo,
    required this.usuTelefono,
    required this.usuEmail,
    required this.password,
    required this.passwordConfirmation,
    this.usuEstado = 1,
    this.usuDireccion = 'Bogotá',
  });
}