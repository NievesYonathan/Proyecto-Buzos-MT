import 'package:flutter/material.dart';

class Customtextformfiel extends StatelessWidget {
  //
  final Key? key;
  final String? value;
  final IconData prefixIcon;
  final String? error;
  final String? labelText;
  final bool isPassword;
  final TextEditingController? controller;
  //
  Customtextformfiel({
    this.key,
    this.value,
    required this.prefixIcon,
    required this.labelText,
    required this.isPassword,
    required this.controller,
    this.error,
  });
  @override
  Widget build(BuildContext context) {
    return TextFormField(
      controller: controller,
      obscureText: isPassword,
      decoration: InputDecoration(
        labelText: labelText,
        floatingLabelStyle: TextStyle(color: Color(0xFF12464C)),
        prefixIcon: Icon(prefixIcon),
        errorText: error,
        errorStyle: TextStyle(color: Colors.red),
      ),
      validator: (value) {
        if (value == null || value.isEmpty) {
          return error;
        }
        return null;
      },
    );
  }
}
