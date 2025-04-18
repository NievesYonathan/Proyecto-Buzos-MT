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

class LoginScreen extends StatelessWidget {
  const LoginScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: GestureDetector(
        onTap: () => FocusScope.of(context).unfocus(),
        child: Stack(
          children: [
            // Fondo gradiente verde
            Positioned.fill(
              child: Container(
                decoration: const BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    end: Alignment.bottomCenter,
                    colors: [Color(0xFF0F969C), Color(0xFF6DA5C0)],
                  ),
                ),
              ),
            ),
            
            // Logo en la parte superior
            
            // Formulario con estilo de la imagen
            Positioned.fill(
              top: 220,
              child: Container(
                decoration: const BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.only(
                    topLeft: Radius.circular(40),
                    topRight: Radius.circular(40),
                  ),
                ),
                child: SingleChildScrollView(
                  padding: const EdgeInsets.symmetric(horizontal: 32.0, vertical: 40.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      // Título
                      const Text(
                        'Sign In',
                        style: TextStyle(
                          fontSize: 28,
                          fontWeight: FontWeight.bold,
                          color: Color(0xFF0F969C),
                        ),
                        textAlign: TextAlign.center,
                      ),
                      const SizedBox(height: 16),
                      
                      // Subtítulo
                      const Text(
                        'Sign in now to access your exercises\nand saved music.',
                        style: TextStyle(
                          fontSize: 14,
                          color: Color(0xFF6DA5C0),
                          height: 1.5,
                        ),
                        textAlign: TextAlign.center,
                      ),
                      const SizedBox(height: 40),
                      
                      // Formulario (con toda la lógica original)
                      const _LoginFormContent(),
                    ],
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
        if (status['status'] != 'success') {
          // Fluttertoast.showToast(
          //   msg: status['message'],
          //   toastLength: Toast.LENGTH_SHORT,
          //   gravity: ToastGravity.BOTTOM,
          //   backgroundColor: const Color.fromARGB(255, 255, 0, 0),
          //   textColor: Colors.white,
          //   fontSize: 16.0,
          // );
          return;
        }
        // Fluttertoast.showToast(
        //   msg: status['message'],
        //   toastLength: Toast.LENGTH_SHORT,
        //   gravity: ToastGravity.BOTTOM,
        //   backgroundColor: const Color.fromARGB(255, 9, 255, 0),
        //   textColor: Colors.white,
        //   fontSize: 16.0,
        // );

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
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          // Tipo de documento (Dropdown)
          FutureBuilder<List<DropdownMenuItem<int>>>(
            future: itemsFuture,
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const Center(child: CircularProgressIndicator());
              } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                return const Text('No hay datos disponibles');
              } else {
                return Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      'Tipo de Documento',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w500,
                        color: Color(0xFF0F969C),
                      ),
                    ),
                    const SizedBox(height: 8),
                     CustomDropdownButtonFormField(
                      labelText: 'Selecciona un tipo de documento',
                      items: snapshot.data!,
                      prefixIcon: Icons.badge,
                      error: _errors['tDocError'],
                      onChanged: (value) {
                        setState(() {
                          tDoc = value;
                        });
                      }
                    ),
                  ],
                );
              } 
            },
          ),
          const SizedBox(height: 20),
          
          // Número de documento
          const Text(
            'Document Number',
            style: TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.w500,
              color: Color(0xFF0F969C),
            ),
          ),
          const SizedBox(height: 8),
          CustomTextFormFiel(
            prefixIcon: Icons.person,
            labelText: 'Ingresa tu numero de documento',
            isPassword: false,
            controller: numDocController,
            error: _errors['numDocError']
          ),
          const SizedBox(height: 20),
          
          // Contraseña
          const Text(
            'Password',
            style: TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.w500,
              color: Color(0xFF0F969C),
            ),
          ),
          const SizedBox(height: 8),
          CustomTextFormFiel(
            prefixIcon: Icons.lock,
            labelText: 'Ingresa Tu contraseña',
            isPassword: true,
            controller: passwordController,
            error: _errors['passwordError'],
          ),
          const SizedBox(height: 16),
          
          // Olvidé mi contraseña
          Align(
            alignment: Alignment.centerRight,
            child: TextButton(
              onPressed: () {},
              child: const Text(
                'Forgot Password?',
                style: TextStyle(
                  fontSize: 14,
                  color: Color(0xFF6DA5C0),
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ),
          const SizedBox(height: 24),
          
          // Botón de Ingresar
          ElevatedButton(
            onPressed: dataValidate,
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFF0F969C),
              padding: const EdgeInsets.symmetric(vertical: 16),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
              elevation: 3,
              shadowColor: Color(0xFF6DA5C0).withOpacity(0.5),
            ),
            child: const Text(
              'LOG IN',
              style: TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.bold,
                color: Colors.white,
              ),
            ),
          ),
          const SizedBox(height: 24),
          
          // No tienes cuenta
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const Text(
                'Don\'t have an account? ',
                style: TextStyle(
                  fontSize: 14,
                  color: Color(0xFF6DA5C0),
                ),
              ),
              TextButton(
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => const RegisterScreen()),
                  );
                },
                child: const Text(
                  'Sign Up',
                  style: TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.bold,
                    color: Color(0xFF0F969C),
                  ),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}