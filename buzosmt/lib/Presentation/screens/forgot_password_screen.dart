import 'package:flutter/material.dart';

class ForgotPasswordScreen extends StatefulWidget {
  const ForgotPasswordScreen({super.key});

  @override
  State<ForgotPasswordScreen> createState() => _ForgotPasswordScreenState();
}

class _ForgotPasswordScreenState extends State<ForgotPasswordScreen> {
  final TextEditingController _emailController = TextEditingController();
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    // Obtener el tamaño de la pantalla para uso en diseño responsive
    final Size screenSize = MediaQuery.of(context).size;
    final bool isSmallScreen = screenSize.width < 600;

    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            colors: [Color(0xFF064c41), Color(0xFF20A67B)],
          ),
        ),
        child: SafeArea(
          child: Center(
            child: SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.all(24.0),
                child: Column(
                  children: [
                    // Card container
                    Container(
                      width: double.infinity,
                      constraints: BoxConstraints(
                        maxWidth: isSmallScreen ? double.infinity : 500,
                      ),
                      padding: EdgeInsets.all(isSmallScreen ? 20 : 24),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(30),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black.withOpacity(0.1),
                            blurRadius: 10,
                            offset: const Offset(0, 5),
                          ),
                        ],
                      ),
                      child: Stack(
                        children: [
                          
                            // Botón de volver en la esquina superior izquierda
                            Positioned(
                            top: 0,
                            left: 0,
                            child: Container(
                              padding: const EdgeInsets.all(2),
                              decoration: BoxDecoration(
                              color: const Color(0xFFF5F5F5),
                              borderRadius: BorderRadius.circular(12),
                              ),
                              child: IconButton(
                              icon: const Icon(Icons.arrow_back, color: Color(0xFF064c41)),
                              onPressed: () => Navigator.pop(context),
                              ),
                            ),
                            ),
                          
                          Form(
                            key: _formKey,
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                // Espacio para no solapar con el botón de retroceso
                                const SizedBox(height: 16),
                                
                                // Logo
                                Center(
                                  child: Padding(
                                  padding: const EdgeInsets.only(top: 10.0, bottom: 20.0),
                                  child: Image.asset(
                                    'assets/images/image.png',
                                    height: isSmallScreen ? 120 : 150, // Increased size
                                    width: double.infinity,
                                    fit: BoxFit.contain,
                                  ),
                                  ),
                                ),
                                const Text(
                                  "Recuperar Contraseña",
                                  style: TextStyle(
                                    color: Color(0xFF064c41),
                                    fontSize: 24,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                
                                const SizedBox(height: 16),
                                
                                const Text(
                                  "Ingresa tu correo electrónico y te enviaremos instrucciones para recuperar tu contraseña.",
                                  style: TextStyle(
                                    color: Colors.grey,
                                    fontSize: 14,
                                  ),
                                ),
                                
                                const SizedBox(height: 24),
                                
                                // Email field
                                const Text(
                                  "Correo Electrónico",
                                  style: TextStyle(
                                    color: Color(0xFF064c41),
                                    fontSize: 14,
                                    fontWeight: FontWeight.w500,
                                  ),
                                ),
                                const SizedBox(height: 8),
                                
                                Container(
                                  decoration: BoxDecoration(
                                    color: const Color(0xFFF5F5F5),
                                    borderRadius: BorderRadius.circular(30),
                                  ),
                                  child: Row(
                                    children: [
                                      const Padding(
                                        padding: EdgeInsets.symmetric(horizontal: 16),
                                        child: Icon(Icons.email_outlined, color: Colors.grey),
                                      ),
                                      Expanded(
                                        child: TextFormField(
                                          controller: _emailController,
                                          keyboardType: TextInputType.emailAddress,
                                          decoration: const InputDecoration(
                                            hintText: "Ingresa tu correo electrónico",
                                            border: InputBorder.none,
                                            hintStyle: TextStyle(color: Colors.grey),
                                          ),
                                          validator: (value) {
                                            if (value == null || value.isEmpty) {
                                              return 'Por favor ingresa tu correo electrónico';
                                            } else if (!RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$').hasMatch(value)) {
                                              return 'Ingresa un correo electrónico válido';
                                            }
                                            return null;
                                          },
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                                
                                const SizedBox(height: 30),
                                
                                // Submit button
                                SizedBox(
                                  width: double.infinity,
                                  height: 55,
                                  child: ElevatedButton(
                                    onPressed: () {
                                      if (_formKey.currentState!.validate()) {
                                        // Implementar lógica para enviar correo de recuperación
                                        ScaffoldMessenger.of(context).showSnackBar(
                                          const SnackBar(
                                            content: Text('Correo de recuperación enviado!'),
                                            backgroundColor: Color(0xFF20A67B),
                                          ),
                                        );
                                      }
                                    },
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: const Color(0xFF20A67B),
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(30),
                                      ),
                                      elevation: 0,
                                    ),
                                    child: const Text(
                                      "Enviar",
                                      style: TextStyle(
                                        color: Colors.white,
                                        fontSize: 16,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
  
  @override
  void dispose() {
    _emailController.dispose();
    super.dispose();
  }
}