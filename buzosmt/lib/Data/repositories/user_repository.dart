// lib/data/repositories/user_repository.dart

import '../../Domains/models/user_model.dart';

abstract class UserRepository {
  Future<void> registerUser(User user);
}

class UserRepositoryImpl implements UserRepository {
  @override
  Future<void> registerUser(User user) async {
    // Aquí iría la lógica para enviar los datos a la API o base de datos.
  }
}