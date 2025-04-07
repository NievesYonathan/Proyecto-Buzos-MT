import 'package:buzosmt/Domains/usecases/getdocs_usecase.dart';
import 'package:buzosmt/Presentation/screens/login_screen.dart';
import '../models/user_model.dart';

class UsesCasesUser {
  final User user;
  UsesCasesUser(this.user);
  Map<String, String> loginValidate() {
  return {
    if (user.tDoc == null || user.tDoc == 0) 'tDocError': 'Selecciona un tipo de documento',
    if (user.numDoc.isEmpty) 'numDocError': 'Número de documento requerido',
    if (user.password.isEmpty) 'passwordError': 'Contraseña requerida',
  };
}
  Future<Map<String, dynamic>> loginUser() async {
    final status = await user.jsonForLogin();
    return status;
  }
}
