import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../theme/app_theme.dart';

class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});
  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> with SingleTickerProviderStateMixin {
  late AnimationController _ctrl;
  late Animation<double> _fade;

  @override
  void initState() {
    super.initState();
    _ctrl = AnimationController(vsync: this, duration: const Duration(milliseconds: 800));
    _fade = CurvedAnimation(parent: _ctrl, curve: Curves.easeIn);
    _ctrl.forward();
    Future.delayed(const Duration(seconds: 2), _navigate);
  }

  Future<void> _navigate() async {
    if (!mounted) return;
    Navigator.pushReplacementNamed(context, '/');
  }

  @override
  void dispose() { _ctrl.dispose(); super.dispose(); }

  @override
  Widget build(BuildContext context) => Scaffold(
    backgroundColor: AppColors.primary,
    body: FadeTransition(
      opacity: _fade,
      child: Center(child: Column(mainAxisSize: MainAxisSize.min, children: [
        Container(width:100, height:100, decoration: BoxDecoration(
          color: Colors.white.withOpacity(0.15),
          shape: BoxShape.circle,
        ), child: const Icon(Icons.factory_rounded, size:56, color:Colors.white)),
        const SizedBox(height: 24),
        const Text('هنرستان هزاره صنعت',
            style: TextStyle(fontSize:22, fontWeight:FontWeight.bold, color:Colors.white)),
        const SizedBox(height: 8),
        Text('اولین هنرستان جوار صنعت غرب کشور',
            style: TextStyle(fontSize:13, color:Colors.white.withOpacity(0.75))),
        const SizedBox(height: 40),
        SizedBox(width:32, height:32, child:
          CircularProgressIndicator(color: AppColors.accent, strokeWidth:2.5)),
      ])),
    ),
  );
}
