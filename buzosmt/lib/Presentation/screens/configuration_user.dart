import 'package:flutter/material.dart';

class ConfigurationUserScreen extends StatelessWidget {
  final Map<String, dynamic> userData; // Recibe los datos del usuario

  const ConfigurationUserScreen({super.key, required this.userData});

  @override
  Widget build(BuildContext context) {
    // Controladores para los campos de texto
    final TextEditingController nombreController = TextEditingController(
      text: '${userData['usu_nombres']} ${userData['usu_apellidos']}',
    );
    final TextEditingController emailController = TextEditingController(
      text: userData['email'] ?? '',
    );

    // Controladores para los campos de contraseña
    final TextEditingController currentPasswordController =
        TextEditingController();
    final TextEditingController newPasswordController = TextEditingController();
    final TextEditingController confirmPasswordController =
        TextEditingController();

    // Definición de los colores principales
    const Color primaryColor = Color(0xFF0D3D4A);
    const Color accentColor = Color(0xFF20A67B);

    final inputDecoration = InputDecoration(
      labelStyle: TextStyle(color: primaryColor.withOpacity(0.8)),
      hintStyle: const TextStyle(color: Colors.grey),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(8.0),
        borderSide: BorderSide(color: Colors.grey.shade300),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(8.0),
        borderSide: BorderSide(color: primaryColor.withOpacity(0.3)),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(8.0),
        borderSide: const BorderSide(color: accentColor, width: 2.0),
      ),
      filled: true,
      fillColor: Colors.white,
    );

    final buttonStyle = ElevatedButton.styleFrom(
      backgroundColor: accentColor,
      foregroundColor: Colors.white,
      padding: const EdgeInsets.symmetric(vertical: 16.0, horizontal: 24.0),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8.0)),
      elevation: 2,
    );

    return Scaffold(
      backgroundColor: Colors.grey.shade100,
      appBar: AppBar(
        title: const Text(
          'Configuración de Usuario',
          style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600),
        ),
        backgroundColor: primaryColor,
        elevation: 0,
        centerTitle: true,
        iconTheme: const IconThemeData(color: Colors.white),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Perfil avatar placeholder
            Center(
              child: Column(
                children: [
                  Container(
                    width: 100,
                    height: 100,
                    decoration: BoxDecoration(
                      color: Colors.grey.shade200,
                      shape: BoxShape.circle,
                      border: Border.all(color: accentColor, width: 3),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.1),
                          blurRadius: 10,
                          offset: const Offset(0, 5),
                        ),
                      ],
                    ),
                    child: CircleAvatar(
                      radius: 50,
                      backgroundColor: Colors.white,
                      backgroundImage:
                          userData['imag_perfil'] != null
                              ? NetworkImage(
                                'http://tu-servidor.com/${userData['imag_perfil']}',
                              )
                              : const AssetImage('assets/images/logo.png')
                                  as ImageProvider,
                    ),
                  ),
                  const SizedBox(height: 10),
                  Text(
                    '${userData['usu_nombres']} ${userData['usu_apellidos']}',
                    style: const TextStyle(
                      color: accentColor,
                      fontWeight: FontWeight.w600,
                      fontSize: 18,
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 32.0),

            // Información del perfil
            Container(
              padding: const EdgeInsets.all(24.0),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12.0),
                boxShadow: [
                  BoxShadow(
                    color: Colors.grey.withOpacity(0.2),
                    spreadRadius: 1,
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  TextField(
                    controller:
                        nombreController, // Muestra el nombre del usuario
                    decoration: inputDecoration.copyWith(
                      labelText: 'Nombre de usuario',
                      prefixIcon: Icon(
                        Icons.account_circle,
                        color: primaryColor.withOpacity(0.6),
                      ),
                    ),
                  ),
                  const SizedBox(height: 20.0),
                  TextField(
                    controller:
                        emailController, // Muestra el correo del usuario
                    decoration: inputDecoration.copyWith(
                      labelText: 'Correo electrónico',
                      prefixIcon: Icon(
                        Icons.email_outlined,
                        color: primaryColor.withOpacity(0.6),
                      ),
                    ),
                  ),
                  const SizedBox(height: 24.0),
                  Row(
                    children: [
                      Expanded(
                        child: ElevatedButton.icon(
                          onPressed: () {
                            // Acción para actualizar
                          },
                          icon: const Icon(Icons.check),
                          label: const Text(
                            'Actualizar',
                            style: TextStyle(fontSize: 16.0),
                          ),
                          style: buttonStyle,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
            const SizedBox(height: 32.0),

            // Actualizar contraseña
            Container(
              padding: const EdgeInsets.all(24.0),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12.0),
                boxShadow: [
                  BoxShadow(
                    color: Colors.grey.withOpacity(0.2),
                    spreadRadius: 1,
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  TextField(
                    controller: currentPasswordController,
                    obscureText: true,
                    decoration: inputDecoration.copyWith(
                      labelText: 'Contraseña actual',
                      prefixIcon: Icon(
                        Icons.vpn_key,
                        color: primaryColor.withOpacity(0.6),
                      ),
                    ),
                  ),
                  const SizedBox(height: 20.0),
                  TextField(
                    controller: newPasswordController,
                    obscureText: true,
                    decoration: inputDecoration.copyWith(
                      labelText: 'Nueva contraseña',
                      prefixIcon: Icon(
                        Icons.lock,
                        color: primaryColor.withOpacity(0.6),
                      ),
                    ),
                  ),
                  const SizedBox(height: 20.0),
                  TextField(
                    controller: confirmPasswordController,
                    obscureText: true,
                    decoration: inputDecoration.copyWith(
                      labelText: 'Confirmar nueva contraseña',
                      prefixIcon: Icon(
                        Icons.lock_clock,
                        color: primaryColor.withOpacity(0.6),
                      ),
                    ),
                  ),
                  const SizedBox(height: 24.0),
                  Row(
                    children: [
                      Expanded(
                        child: ElevatedButton.icon(
                          onPressed: () {
                            // Acción para actualizar contraseña
                          },
                          icon: const Icon(Icons.security),
                          label: const Text(
                            'Actualizar contraseña',
                            style: TextStyle(fontSize: 16.0),
                          ),
                          style: buttonStyle,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
