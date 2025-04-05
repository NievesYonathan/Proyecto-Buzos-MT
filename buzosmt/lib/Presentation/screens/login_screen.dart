import 'dart:ffi';

import 'package:flutter/material.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/customTextField.dart';
import 'package:buzosmt/Presentation/Widgets/Inputs/Customtextformfiel.dart';
import 'package:buzosmt/Domains/usecases/login_user.dart';
import 'package:buzosmt/Domains/usecases/getdocs_usecase.dart';

class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  int? tDoc;
  // final TextEd itingController tDocController = TextEditingController();
  final TextEditingController numDocController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();
  List<DropdownMenuItem<int>> items = [];
  Map<int, String> docItems = {};
  Map<String?, dynamic> _errors = {};

  @override
  void initState() {
    super.initState();
    _loadDocs();
  }

  Future<void> _loadDocs() async {
    final Tdoc tDocUseCase = Tdoc();
  final docs = await tDocUseCase.getDocumentosMap();

  setState(() {
    docItems = docs;
    items = docs.entries.map((e) => DropdownMenuItem<int>(
              value: e.key,
              child: Text(e.value),
            ))
        .toList();
  });
  }

  Future<void> dataValidate() async {
    if (_formKey.currentState!.validate()) {
      UserValidator validator = UserValidator();
      final errors = await validator.validateLogin(
        tDoc,
        numDocController.text,
        passwordController.text,
      );
      setState(() {
        _errors = errors;
      });
      if (_errors.isEmpty) {
        // print('Data correcta');
        // Aquí iría la lógica para navegar o hacer el login real
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          Container(
            height: double.infinity,
            width: double.infinity,
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                colors: [Color(0xFF12464C), Color(0xFF34E69F)],
              ),
            ),
            child: Padding(
              padding: const EdgeInsets.only(top: 20.0, left: 15.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  ElevatedButton(
                    onPressed: () {
                      Navigator.pop(context);
                    },
                    child: const Icon(Icons.arrow_back),
                  ),
                  const SizedBox(height: 10),
                  const Text(
                    '¡Hola,\nBienvenido! a Buzos Mt',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 20,
                      color: Colors.white,
                    ),
                  ),
                ],
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.only(top: 300.0),
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
              child: Form(
                key: _formKey,
                child: Padding(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 18.0,
                    vertical: 30.0,
                  ),
                  child: Column(
                    children: [
                      CustomDropdownButtonFormField(
                        labelText: 'Tipo de documento',
                        items: items,
                        prefixIcon: Icons.badge,
                        error: _errors['tDocError'],
                        onChanged: (value) {
                          setState(() {
                            tDoc = value;
                          });
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
                      Container(
                        height: 55,
                        width: double.infinity,
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(30),
                          color: const Color.fromARGB(255, 15, 52, 67),
                        ),
                        child: ElevatedButton(
                          style: ElevatedButton.styleFrom(
                            backgroundColor: Colors.transparent,
                            shadowColor: Colors.transparent,
                          ),
                          onPressed: () {
                            dataValidate();
                          },
                          child: const Text(
                            'Ingresar',
                            style: TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.bold,
                              fontSize: 20,
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
