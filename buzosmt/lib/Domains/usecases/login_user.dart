import '../models/user_model.dart';

class UsesCasesUser {
  final User user;
  UsesCasesUser(this.user);

  Map<String, String> loginValidate() {
    if (user.tDoc == null || user.tDoc == 0) {
      return {'tDocError': 'Selecciona un tipo de documento'};
    }
    // if (user.numDoc.isEmpty) {
    //   return {'numDocError': 'Número de documento requerido'};
    // }
    // if (RegExp(r'[a-zA-Z]').hasMatch(user.numDoc)) {
    //   return {'numDocError': 'El número de documento no puede contener letras'};
    // }
    // if (user.numDoc.length > 10) {
    //   return {
    //     'numDocError':
    //         'El numero de documento no puede tener más de 10 dígitos',
    //   };
    // }
    // if (user.numDoc.length < 10) {
    //   return {
    //     'numDocError':
    //         'El numero de documento no puede tener menos de 10 dígitos',
    //   };
    // }
    // if (user.password.isEmpty) {
    //   return {'passwordError': 'Contraseña requerida'};
    // }
    // if (user.password.length < 6) {
    //   return {
    //     'passwordError': 'La contraseña debe tener al menos 6 caracteres',
    //   };
    // }
    return {}; // Sin errores
  }

  Map<String, String> registerValidate() {
    if (user.tDoc == null || user.tDoc == 0) {
      return {'tDocError': 'Selecciona un tipo de documento'};
    }
    if (user.numDoc == null) {
      return {'numDocError': 'Número de documento requerido'};
    }
    // if (user.numDoc.length > 10) {
    //   return {
    //     'numDocError':
    //         'El numero de documento no puede tener más de 10 dígitos',
    //   };
    // }
    // if (user.numDoc.length < 10) {
    //   return {
    //     'numDocError':
    //         'El numero de documento no puede tener menos de 10 dígitos',
    //   };
    // }
    // if (RegExp(r'[a-zA-Z]').hasMatch(user.numDoc)) {
    //   return {'numDocError': 'El número de documento no puede contener letras'};
    // }
    if (user.usuNombres!.isEmpty) {
      return {'usuNombresError': 'El nombre es requerido'};
    }

    if (user.usuApellidos!.isEmpty) {
      return {
        'usuApellidosError': 'El nombre debe tener al menos 3 caracteres',
      };
    }
    // if (user.password.isEmpty) {
    //   return {'passwordError': 'Contraseña requerida'};
    // }
    // if (user.password.length < 6) {
    //   return {
    //     'passwordError': 'La contraseña debe tener al menos 6 caracteres',
    //   };
    // }
    if (user.usuEmail!.isEmpty) {
      return {'usuEmailError': 'Correo electrónico requerido'};
    }
    if (!RegExp(r'^[^@]+@[^@]+\.[^@]+').hasMatch(user.usuEmail!)) {
      return {'usuEmailError': 'Correo electrónico no válido'};
    }
    if (user.passwordConfirmation != user.password) {
      return {'passwordConfirmationError': 'Las Contraseñas no coinciden'};
    }
    if (user.password != user.passwordConfirmation) {
      return {'passwordError': 'Las Contraseñas no coinciden'};
    }
    if (user.usuFechaNacimiento == '') {
      return {'usuFechaError': 'La fecha de nacimiento es requerida'};
    }
    if (user.usuSexo == '') {
      return {'usuSexoError': 'El sexo es requerido'};
    }
    if (user.usuTelefono == '') {
      return {'usuTelError': 'El teléfono es requerido'};
    }

    return {}; // Sin errores
  }

  Future<Map<String, dynamic>> loginUser() async {
    final status = await user.jsonForLogin();
    return status;
  }

  Future<Map<String, dynamic>> registerUser() async {
    final status = await user.jsonForRegister();
    return status;
  }
}
