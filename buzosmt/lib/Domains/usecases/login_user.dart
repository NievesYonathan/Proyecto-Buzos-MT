import 'package:buzosmt/Presentation/screens/login_screen.dart';
import '../models/user_model.dart';

class UserValidator {
  Future<Map<String?, dynamic>> validateLogin(
    int? tDoc,
    String numDoc,
    String password,
  ) async {
    final errors = {
      if (tDoc == 0 || tDoc == null) 'tDocError': 'Tipo de documento no válido',
      if (numDoc.isEmpty) 'numDocError': 'Número de documento requerido',
      if (password.isEmpty) 'passwordError': 'Contraseña requerida',
    };
    if (errors.isEmpty) {
      final User user = User(tDoc: tDoc, numDoc: numDoc, password: password);
      user.jsonForLogin();
    }

    return errors;
  }
}
