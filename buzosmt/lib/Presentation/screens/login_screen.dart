import 'package:buzosmt/Domains/models/user_model.dart';
import 'package:buzosmt/Presentation/screens/dashboard_screen.dart';
import 'package:flutter/material.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/customTextField.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/Customtextformfiel.dart';
import 'package:buzosmt/Domains/usecases/login_user.dart';
import 'package:buzosmt/Domains/usecases/getdocs_usecase.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:buzosmt/Presentation/Widgets/butons/customelevatedbutton.dart';
import 'package:buzosmt/Presentation/screens/register_screen.dart';
import 'package:buzosmt/Presentation/screens/forgot_password_screen.dart';
import 'package:buzosmt/main.dart'; // Asegúrate de crear este archivo
import 'package:google_sign_in/google_sign_in.dart';

class LoginScreen extends StatelessWidget {
  const LoginScreen({super.key});

  Future<void> _signInWithGoogle(BuildContext context) async {
    try {
      final GoogleSignIn googleSignIn = GoogleSignIn();
      final GoogleSignInAccount? googleUser = await googleSignIn.signIn();

      if (googleUser == null) {
        // El usuario canceló el inicio de sesión
        return;
      }

      final GoogleSignInAuthentication googleAuth =
          await googleUser.authentication;

      // Aquí obtienes el token de acceso y el ID token
      final String? accessToken = googleAuth.accessToken;
      final String? idToken = googleAuth.idToken;

      // Envía estos tokens a tu backend para validarlos o crear una sesión
      // Por ejemplo:
      // await tuBackendLogin(accessToken, idToken);

      // Navega al Dashboard después del inicio de sesión exitoso
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => Dashboard()),
      );
    } catch (e) {
      // Maneja errores de inicio de sesión
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Error al iniciar sesión con Google: $e")),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: GestureDetector(
        onTap: () => FocusScope.of(context).unfocus(),
        child: Container(
          decoration: const BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topCenter,
              end: Alignment.bottomCenter,
              colors: [Color(0xFF064c41), Color(0xFF20A67B)],
            ),
          ),
          child: SafeArea(
            child: SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.all(24.0),
                child: Column(
                  children: [
                    // Main card with logo and login form
                    Container(
                      width: double.infinity,
                      padding: const EdgeInsets.all(24),
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
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          // Botón con flecha hacia la izquierda
                          InkWell(
                            onTap: () {
                              Navigator.pushReplacement(
                                context,
                                MaterialPageRoute(
                                  builder: (context) => const BuzosMt(), // Reemplaza con tu clase de MainScreen
                                ),
                              );
                            },
                            child: Container(
                                padding: const EdgeInsets.all(8),
                                decoration: BoxDecoration(
                                color: const Color(0xFFF5F5F5),
                                borderRadius: BorderRadius.circular(12),
                                    ),
                              child: const Icon(
                                Icons.arrow_back,
                                color: Color(0xFF064c41),
                                size: 24,
                              ),
                            ),
                          ),
                          const SizedBox(height: 12),

                          // Logo (reemplazar con tu imagen)
                          Center(
                            child: Padding(
                              padding: const EdgeInsets.only(bottom: 20.0),
                              child: Image.asset(
                                'assets/images/image.png', // Reemplaza esta ruta con la ubicación de tu logo
                                height: 130, // Aumentado de 100 a 130
                                width: double.infinity,
                                fit: BoxFit.contain,
                              ),
                            ),
                          ),

                          // App name "LOGIN PAGE"
                          const Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Text(
                                "BUZOS",
                                style: TextStyle(
                                  color: Color(0xFF064c41),
                                  fontSize: 32,
                                  fontWeight: FontWeight.bold,
                                ),
                              ),
                              Text(
                                "MT",
                                style: TextStyle(
                                  color: Color(0xFF20A67B),
                                  fontSize: 28,
                                  fontWeight: FontWeight.bold,
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(height: 30),

                          // Login form content
                          const _LoginFormContent(),

                          const SizedBox(height: 20),

                          // Google Login Button
                          Center(
                          child:ElevatedButton.icon(
                            onPressed: () => _signInWithGoogle(context),
                            style: ElevatedButton.styleFrom(
                              backgroundColor: Colors.white,
                              foregroundColor: Colors.grey[800],
                              padding: const EdgeInsets.symmetric(
                                vertical: 13,
                                horizontal: 12,
                              ),
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(30),
                                side: BorderSide(color: Colors.grey[300]!),
                              ),
                              elevation: 2,
                            ),
                            icon: Image.asset(
                              'assets/images/google.png', // Reemplaza con la ruta correcta a tu logo de Google
                              height: 24,
                              width: 24,
                            ),
                            label: const Text(
                              "Iniciar Sesión con Google",
                              style: TextStyle(fontSize: 16),
                            ),
                          ),
                          )
                        ],
                      ),
                    ),

                    // Sign up option
                    const SizedBox(height: 20),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Text(
                          "No Tienes Una Cuenta? ",
                          style: TextStyle(color: Colors.white, fontSize: 14),
                        ),
                        GestureDetector(
                          onTap: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => const RegisterScreen(),
                              ),
                            );
                          },
                          child: const Text(
                            "Registrarme",
                            style: TextStyle(
                              color: Color(0xFF064c41),
                              fontSize: 14,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ),
                      ],
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
}

class _LoginFormContent extends StatefulWidget {
  const _LoginFormContent();

  @override
  State<_LoginFormContent> createState() => _LoginFormContentState();
}

class _LoginFormContentState extends State<_LoginFormContent> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  int? tDoc;
  final TextEditingController numDocController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  late Future<List<DropdownMenuItem<int>>> itemsFuture;
  Map<String?, dynamic> _errors = {};
  bool _rememberMe = false;

  @override
  void initState() {
    super.initState();
    itemsFuture = cargarDocs();
  }

  Future<List<DropdownMenuItem<int>>> cargarDocs() async {
    final Tdoc tDocUseCase = Tdoc();
    final docs = await tDocUseCase.getDocumentosMap();
    return docs.entries
        .map((e) => DropdownMenuItem<int>(value: e.key, child: Text(e.value)))
        .toList();
  }

  Future<void> dataValidate() async {
    FocusScope.of(context).unfocus();
    if (_formKey.currentState!.validate()) {
      UsesCasesUser validator = UsesCasesUser(
        User(
          tDoc: tDoc,
          numDoc: numDocController.text,
          password: passwordController.text,
        ),
      );
      
      
      final errors = validator.loginValidate();

      setState(() {
        _errors = errors;
      });
      if (_errors.isEmpty) {
        final status = await validator.loginUser();
        // print(status);
        if (status['status'] != 'success') {
          numDocController.clear();
          passwordController.clear();
          // Handle error
          Fluttertoast.showToast(
            msg: status['message'],
            toastLength: Toast.LENGTH_SHORT,
            gravity: ToastGravity.BOTTOM,
            backgroundColor: Colors.red,
            textColor: Colors.white,
            fontSize: 16.0,
          );
          return;
        }

        Navigator.push(
          context,
          MaterialPageRoute(builder: (context) => Dashboard()),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Form(
      key: _formKey,
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Tipo de documento
          const Text(
            "Tipo De Documento",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          // Document Type Dropdown
          FutureBuilder<List<DropdownMenuItem<int>>>(
            future: itemsFuture,
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const Center(child: CircularProgressIndicator());
              } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                return const Text('No hay datos disponibles');
              } else {
                return Container(
                  decoration: BoxDecoration(
                    color: const Color(0xFFF5F5F5),
                    borderRadius: BorderRadius.circular(30),
                  ),
                  child: Row(
                    children: [
                      const Padding(
                        padding: EdgeInsets.symmetric(horizontal: 16),
                        child: Icon(Icons.badge, color: Colors.grey),
                      ),
                      Expanded(
                        child: DropdownButtonFormField<int>(
                          value: tDoc,
                          decoration: const InputDecoration(
                            hintText: "Selecciona un tipo de documento",
                            border: InputBorder.none,
                            hintStyle: TextStyle(color: Colors.grey),
                            contentPadding: EdgeInsets.symmetric(vertical: 12),
                          ),
                          items: snapshot.data,
                          onChanged: (value) {
                            setState(() {
                              tDoc = value;
                            });
                          },
                          icon: const Icon(
                            Icons.arrow_drop_down,
                            color: Color(0xFF064c41),
                          ),
                          isExpanded: true,
                          dropdownColor: Colors.white,
                        ),
                      ),
                    ],
                  ),
                );
              }
            },
          ),

          if (_errors['tDocError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['tDocError'],
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          const SizedBox(height: 20),

          // Número de documento
          const Text(
            "Numero De Documento",
            style: TextStyle(
              color: Color(0xFF064c41),
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),

          // Document Number Field (sin el chulito)
          Container(
            decoration: BoxDecoration(
              color: const Color(0xFFF5F5F5),
              borderRadius: BorderRadius.circular(30),
            ),
            child: Row(
              children: [
                const Padding(
                  padding: EdgeInsets.symmetric(horizontal: 16),
                  child: Icon(Icons.person_outline, color: Colors.grey),
                ),
                Expanded(
                  child: TextFormField(
                    controller: numDocController,
                    decoration: const InputDecoration(
                      hintText: "Ingresa tu número de documento",
                      border: InputBorder.none,
                      hintStyle: TextStyle(color: Colors.grey),
                    ),
                  ),
                ),
                // Se eliminó el chulito aquí
              ],
            ),
          ),

          if (_errors['numDocError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['numDocError'],
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          const SizedBox(height: 20),

          // Password Field
          const Text(
            "Contaseña",
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
                  child: Icon(Icons.lock_outline, color: Colors.grey),
                ),
                Expanded(
                  child: TextFormField(
                    controller: passwordController,
                    obscureText: true,
                    decoration: const InputDecoration(
                      hintText: "Ingresa tu contraseña",
                      border: InputBorder.none,
                      hintStyle: TextStyle(color: Colors.grey),
                    ),
                  ),
                ),
              ],
            ),
          ),

          if (_errors['passwordError'] != null)
            Padding(
              padding: const EdgeInsets.only(top: 4, left: 16),
              child: Text(
                _errors['passwordError'],
                style: const TextStyle(color: Colors.red, fontSize: 12),
              ),
            ),

          const SizedBox(height: 16),

          // Remember me and Forgot password
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              // Remember me checkbox
              Row(
                children: [
                  SizedBox(
                    width: 24,
                    height: 24,
                    child: Checkbox(
                      value: _rememberMe,
                      onChanged: (value) {
                        setState(() {
                          _rememberMe = value ?? false;
                        });
                      },
                      activeColor: const Color(0xFF20A67B),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(4),
                      ),
                    ),
                  ),
                  const SizedBox(width: 8),
                  const Text(
                    "Recordarme",
                    style: TextStyle(color: Colors.grey, fontSize: 14),
                  ),
                ],
              ),

              // Forgot password - Modificado para navegar a otra pantalla
              GestureDetector(
                onTap: () {
                  // Navegar a la pantalla de olvidé mi contraseña
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => const ForgotPasswordScreen(), // Crea este archivo
                    ),
                  );
                },
                child: const Text(
                  "Olvide Mi Contraseña",
                  style: TextStyle(color: Color(0xFF20A67B), fontSize: 14),
                ),
              ),
            ],
          ),
          const SizedBox(height: 30),

          // Sign In Button
          SizedBox(
            width: double.infinity,
            height: 55,
            child: ElevatedButton(
              onPressed: dataValidate,
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF20A67B),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(30),
                ),
                elevation: 0,
              ),
              child: const Text(
                "Iniciar Sesión",
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
    );
  }
}