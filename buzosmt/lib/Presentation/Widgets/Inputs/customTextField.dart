import 'package:flutter/material.dart';

class CustomDropdownButtonFormField extends StatelessWidget {
  final String labelText;
  final List<DropdownMenuItem<int>> items;
  final int ? value;
  final ValueChanged<int?> onChanged;
  final FormFieldValidator<int> ? validator;
  final IconData? prefixIcon;
  final String? error;

  const CustomDropdownButtonFormField({
    super.key,
    required this.labelText,
    required this.items,
    required this.error,
    this.value,
    required this.onChanged,
    this.validator,
    this.prefixIcon
  });

  @override
  Widget build(BuildContext context) {
    return DropdownButtonFormField<int>(
      decoration: InputDecoration(
        floatingLabelStyle: const TextStyle(color: Color(0xFF12464C)),
        labelText: labelText,
        errorText: error,
        errorStyle: TextStyle(color: Colors.red),
        prefixIcon: Icon(prefixIcon),
      ),
      value: value,
      items: items,
      onChanged: onChanged,
      validator:
          validator ??
          (value) {
            if (value == null || value == 0) {
              return error;
            }
            return null;
          },
    );
  }
}
