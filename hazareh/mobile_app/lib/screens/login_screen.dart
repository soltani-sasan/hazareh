import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/common.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});
  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _nidCtrl = TextEditingController();
  final _passCtrl = TextEditingController();
  bool _loading = false;
  bool _obscure = true;
  String? _error;

  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) return;
    setState(() { _loading = true; _error = null; });
    try {
      final res = await ApiService.login(_nidCtrl.text.trim(), _passCtrl.text);
      if (!mounted) return;
      if (res['success'] == true) {
        Navigator.pushReplacementNamed(context, '/profile');
      } else {
        setState(() { _error = res['message'] ?? 'خطا در ورود'; _loading = false; });
      }
    } catch (e) {
      if (mounted) setState(() { _error = 'خطا در اتصال به سرور'; _loading = false; });
    }
  }

  @override
  void dispose() { _nidCtrl.dispose(); _passCtrl.dispose(); super.dispose(); }

  @override
  Widget build(BuildContext context) => Scaffold(
    backgroundColor: AppColors.bg,
    body: SafeArea(child: SingleChildScrollView(
      padding: const EdgeInsets.all(24),
      child: Form(
        key: _formKey,
        child: Column(children:[
          const SizedBox(height: 40),
          Container(width:80, height:80, decoration:const BoxDecoration(
            color:AppColors.primary, shape:BoxShape.circle),
            child:const Icon(Icons.lock_outline, size:40, color:Colors.white)),
          const SizedBox(height: 24),
          const Text('ورود به سامانه',
              style:TextStyle(fontSize:22, fontWeight:FontWeight.bold, color:AppColors.primary)),
          const SizedBox(height: 6),
          Text('هنرستان هزاره صنعت',
              style:TextStyle(fontSize:13, color:Colors.grey.shade600)),
          const SizedBox(height: 32),

          if (_error != null) Container(
            margin:const EdgeInsets.only(bottom:16),
            padding:const EdgeInsets.all(12),
            decoration:BoxDecoration(color:Colors.red.shade50,
                borderRadius:BorderRadius.circular(10),
                border:Border.all(color:Colors.red.shade200)),
            child:Row(children:[
              const Icon(Icons.error_outline, color:Colors.red, size:18),
              const SizedBox(width:8),
              Expanded(child:Text(_error!, style:const TextStyle(color:Colors.red, fontSize:13))),
            ]),
          ),

          TextFormField(
            controller: _nidCtrl,
            keyboardType: TextInputType.number,
            textDirection: TextDirection.ltr,
            maxLength: 10,
            decoration: const InputDecoration(
              labelText: 'کد ملی',
              prefixIcon: Icon(Icons.badge_outlined),
              counterText: '',
            ),
            validator: (v) => (v==null||v.length!=10) ? 'کد ملی ۱۰ رقم باشد' : null,
          ),
          const SizedBox(height: 16),
          TextFormField(
            controller: _passCtrl,
            obscureText: _obscure,
            decoration: InputDecoration(
              labelText: 'رمز عبور',
              prefixIcon: const Icon(Icons.lock_outlined),
              suffixIcon: IconButton(
                icon: Icon(_obscure ? Icons.visibility_off : Icons.visibility),
                onPressed: () => setState(() => _obscure = !_obscure),
              ),
            ),
            validator: (v) => (v==null||v.length<4) ? 'رمز عبور را وارد کنید' : null,
          ),
          const SizedBox(height: 24),
          PrimaryButton(label: 'ورود', onPressed: _login, loading: _loading),
          const SizedBox(height: 16),
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('بازگشت بدون ورود'),
          ),
        ]),
      ),
    )),
  );
}
