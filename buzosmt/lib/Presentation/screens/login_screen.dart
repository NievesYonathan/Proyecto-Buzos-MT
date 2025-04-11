import 'package:buzosmt/Domains/models/user_model.dart';
import 'package:buzosmt/Presentation/screens/dashboard_screen.dart';
import 'package:flutter/material.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/customTextField.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/Customtextformfiel.dart';
import 'package:buzosmt/Domains/usecases/login_user.dart';
import 'package:buzosmt/Domains/usecases/getdocs_usecase.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:buzosmt/Presentation/Widgets/butons/customelevatedbutton.dart';

class LoginScreen extends StatelessWidget {
  const LoginScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => FocusScope.of(context).unfocus(),
      child: const Scaffold(
        body: Stack(
          children: [
            LoginHeader(),
            LoginFormSection(), // Se movió el widget aquí
          ],
        ),
      ),
    );
  }
}

class LoginHeader extends StatelessWidget {
  const LoginHeader({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      height: double.infinity,
      width: double.infinity,
      decoration: const BoxDecoration(
        gradient: LinearGradient(
          colors: [Color(0xFF12464C), Color(0xFF34E69F)],
        ),
      ),
      child: Padding(
        padding: const EdgeInsets.only(top: 50.0, left: 15.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            IconButton(
              icon: const Icon(Icons.arrow_back, color: Colors.white, size: 30),
              onPressed: () {
                Navigator.pop(context);
              },
            ),
            const SizedBox(height: 10),
            const Text(
              '¡Hola,\nBienvenido! a Buzos Mt',
              style: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 35,
                color: Colors.white,
              ),
            ),
            const SizedBox(height: 10),
            Center(
              child: Image.asset(
                'assets/images/logo.png',
                width: MediaQuery.of(context).size.width * 0.45,
                fit: BoxFit.contain,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class LoginFormSection extends StatelessWidget {
  const LoginFormSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(top: 500.0),
      child: Container(
        height: double.infinity,
        width: double.infinity,
        decoration: const BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.only(
            topLeft: Radius.circular(30),
            topRight: Radius.circular(30),
          ),
        ),
        child: const _LoginFormContent(), // Contenido separado
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
          Fluttertoast.showToast(
            msg: status['message'],
            toastLength: Toast.LENGTH_SHORT,
            gravity: ToastGravity.BOTTOM,
            backgroundColor: const Color.fromARGB(255, 255, 0, 0),
            textColor: Colors.white,
            fontSize: 16.0,
          );
          return;
        }
        Fluttertoast.showToast(
          msg: status['message'],
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          backgroundColor: const Color.fromARGB(255, 9, 255, 0),
          textColor: Colors.white,
          fontSize: 16.0,
        );

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
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 18.0, vertical: 30.0),
        child: Column(
          children: [
            FutureBuilder<List<DropdownMenuItem<int>>>(
              future: itemsFuture,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const CircularProgressIndicator();
                }
                //  else if (snapshot.hasError) {
                //   return const Text('Error al cargar los datos'); }
                else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                  return const Text('No hay datos disponibles');
                } else {
                  return CustomDropdownButtonFormField(
                    labelText: 'Tipo de documento',
                    items: snapshot.data!,
                    prefixIcon: Icons.badge,
                    error: _errors['tDocError'],
                    onChanged: (value) {
                      setState(() {
                        tDoc = value;
                      });
                    },
                  );
                }
              },
            ),
            const SizedBox(height: 10),
            Customtextformfiel(
              prefixIcon: Icons.person,
              labelText: 'Numero de documento',
              isPassword: false,
              controller: numDocController,
              error: _errors['numDocError'],
            ),
            const SizedBox(height: 10),
            Customtextformfiel(
              prefixIcon: Icons.lock,
              labelText: 'Contraseña',
              isPassword: true,
              controller: passwordController,
              error: _errors['passwordError'],
            ),
            const SizedBox(height: 20),
            CustomElevatedButton(text: 'Ingresar', onPressed: dataValidate),
          ],
        ),
      ),
    );
  }
}
