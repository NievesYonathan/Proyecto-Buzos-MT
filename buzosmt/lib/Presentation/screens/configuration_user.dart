import 'package:flutter/material.dart';

class ConfigurationUserScreen extends StatelessWidget {
  const ConfigurationUserScreen({super.key});
  
  // Definición de los colores principales
  static const Color primaryColor = Color(0xFF0D3D4A);
  static const Color accentColor = Color(0xFF20A67B);
  
  @override
  Widget build(BuildContext context) {
    // Definimos un tema para los botones y campos de texto
    final inputDecoration = InputDecoration(
      labelStyle: TextStyle(color: primaryColor.withOpacity(0.8)),
      hintStyle: TextStyle(color: Colors.grey),
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
        borderSide: BorderSide(color: accentColor, width: 2.0),
      ),
      filled: true,
      fillColor: Colors.white,
    );

    final buttonStyle = ElevatedButton.styleFrom(
      backgroundColor: accentColor,
      foregroundColor: Colors.white,
      padding: EdgeInsets.symmetric(vertical: 16.0, horizontal: 24.0),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(8.0),
      ),
      elevation: 2,
    );
    
    final sectionHeadingStyle = TextStyle(
      fontSize: 20.0,
      fontWeight: FontWeight.bold,
      color: primaryColor,
      letterSpacing: 0.5,
    );

    return Scaffold(
      backgroundColor: Colors.grey.shade100,
      appBar: AppBar(
        title: Text(
          'Configuración de Usuario',
          style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600),
        ),
        backgroundColor: primaryColor,
        elevation: 0,
        centerTitle: true,
        iconTheme: IconThemeData(color: Colors.white),
      ),
      body: SingleChildScrollView(
        padding: EdgeInsets.all(20.0),
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
                          offset: Offset(0, 5),
                        ),
                      ],
                    ),
                    child: Icon(
                      Icons.person,
                      size: 60,
                      color: primaryColor,
                    ),
                  ),
                  SizedBox(height: 10),
                  Text(
                    'Editar Perfil',
                    style: TextStyle(
                      color: accentColor,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ],
              ),
            ),
            SizedBox(height: 32.0),
            
            // First Container: Información del perfil
            Container(
              padding: EdgeInsets.all(24.0),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12.0),
                boxShadow: [
                  BoxShadow(
                    color: Colors.grey.withOpacity(0.2),
                    spreadRadius: 1,
                    blurRadius: 10,
                    offset: Offset(0, 4),
                  ),
                ],
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      Icon(Icons.person_outline, color: accentColor),
                      SizedBox(width: 8.0),
                      Text(
                        'Información del perfil',
                        style: sectionHeadingStyle,
                      ),
                    ],
                  ),
                  Divider(
                    color: primaryColor.withOpacity(0.1),
                    thickness: 1.0,
                    height: 32.0,
                  ),
                  SizedBox(height: 8.0),
                  TextField(
                    decoration: inputDecoration.copyWith(
                      labelText: 'Nombre de usuario',
                      hintText: 'Usuario estático',
                      prefixIcon: Icon(Icons.account_circle, color: primaryColor.withOpacity(0.6)),
                    ),
                  ),
                  SizedBox(height: 20.0),
                  TextField(
                    decoration: inputDecoration.copyWith(
                      labelText: 'Correo electrónico',
                      hintText: 'correo@ejemplo.com',
                      prefixIcon: Icon(Icons.email_outlined, color: primaryColor.withOpacity(0.6)),
                    ),
                  ),
                  SizedBox(height: 24.0),
                  Row(
                    children: [
                      Expanded(
                        child: ElevatedButton.icon(
                          onPressed: () {
                            // Acción para actualizar
                          },
                          icon: Icon(Icons.check),
                          label: Text('Actualizar', style: TextStyle(fontSize: 16.0)),
                          style: buttonStyle,
                        ),
                      ),
                    ],
                  ),
                  SizedBox(height: 16.0),
                  OutlinedButton.icon(
                    onPressed: () {
                      // Acción para adjuntar imagen
                    },
                    icon: Icon(Icons.add_photo_alternate, color: accentColor),
                    label: Text('Adjuntar imagen', style: TextStyle(fontSize: 16.0)),
                    style: OutlinedButton.styleFrom(
                      foregroundColor: accentColor,
                      side: BorderSide(color: accentColor),
                      padding: EdgeInsets.symmetric(vertical: 16.0, horizontal: 24.0),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(8.0),
                      ),
                    ),
                  ),
                ],
              ),
            ),
            SizedBox(height: 32.0),
            
            // Second Container: Actualizar contraseña
            Container(
              padding: EdgeInsets.all(24.0),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12.0),
                boxShadow: [
                  BoxShadow(
                    color: Colors.grey.withOpacity(0.2),
                    spreadRadius: 1,
                    blurRadius: 10,
                    offset: Offset(0, 4),
                  ),
                ],
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      Icon(Icons.lock_outline, color: accentColor),
                      SizedBox(width: 8.0),
                      Text(
                        'Actualizar contraseña',
                        style: sectionHeadingStyle,
                      ),
                    ],
                  ),
                  Divider(
                    color: primaryColor.withOpacity(0.1),
                    thickness: 1.0,
                    height: 32.0,
                  ),
                  SizedBox(height: 8.0),
                  TextField(
                    obscureText: true,
                    decoration: inputDecoration.copyWith(
                      labelText: 'Contraseña actual',
                      prefixIcon: Icon(Icons.vpn_key, color: primaryColor.withOpacity(0.6)),
                    ),
                  ),
                  SizedBox(height: 20.0),
                  TextField(
                    obscureText: true,
                    decoration: inputDecoration.copyWith(
                      labelText: 'Nueva contraseña',
                      prefixIcon: Icon(Icons.lock, color: primaryColor.withOpacity(0.6)),
                    ),
                  ),
                  SizedBox(height: 20.0),
                  TextField(
                    obscureText: true,
                    decoration: inputDecoration.copyWith(
                      labelText: 'Confirmar nueva contraseña',
                      prefixIcon: Icon(Icons.lock_clock, color: primaryColor.withOpacity(0.6)),
                    ),
                  ),
                  SizedBox(height: 24.0),
                  Row(
                    children: [
                      Expanded(
                        child: ElevatedButton.icon(
                          onPressed: () {
                            // Acción para actualizar contraseña
                          },
                          icon: Icon(Icons.security),
                          label: Text('Actualizar contraseña', style: TextStyle(fontSize: 16.0)),
                          style: buttonStyle,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
            
            SizedBox(height: 40.0),
            
            // Botón de cerrar sesión
            Container(
              width: double.infinity,
              child: OutlinedButton.icon(
                onPressed: () {
                  // Acción para cerrar sesión
                },
                icon: Icon(Icons.logout, color: Colors.red.shade700),
                label: Text('Cerrar sesión', style: TextStyle(fontSize: 16.0)),
                style: OutlinedButton.styleFrom(
                  foregroundColor: Colors.red.shade700,
                  side: BorderSide(color: Colors.red.shade300),
                  padding: EdgeInsets.symmetric(vertical: 16.0),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8.0),
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}