import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/common.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});
  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  Map? _user;
  bool _loading = true;
  bool _loggedIn = false;

  @override
  void initState() { super.initState(); _check(); }

  Future<void> _check() async {
    _loggedIn = await ApiService.isLoggedIn();
    if (_loggedIn) {
      try {
        final d = await ApiService.getMe();
        if (mounted) setState(() { _user = d['data']; _loading = false; });
      } catch (_) {
        if (mounted) setState(() => _loading = false);
      }
    } else {
      if (mounted) setState(() => _loading = false);
    }
  }

  Future<void> _logout() async {
    await ApiService.logout();
    if (mounted) { _loggedIn = false; _user = null; setState(() {}); }
  }

  @override
  Widget build(BuildContext context) => Scaffold(
    appBar: AppBar(title: const Text('پروفایل کاربری')),
    body: _loading ? const LoadingState() :
    !_loggedIn ? Center(child: Padding(
      padding: const EdgeInsets.all(32),
      child: Column(mainAxisSize:MainAxisSize.min, children:[
        const Icon(Icons.person_outline, size:64, color:AppColors.primary),
        const SizedBox(height:16),
        const Text('برای دسترسی به پروفایل وارد شوید',
            textAlign:TextAlign.center, style:TextStyle(fontSize:16)),
        const SizedBox(height:24),
        PrimaryButton(label:'ورود / ثبت‌نام',
            onPressed:()=>Navigator.pushNamed(context,'/login').then((_)=>_check())),
        const SizedBox(height:12),
        OutlinedButton(
          onPressed:()=>Navigator.pushNamed(context,'/reg-check'),
          child:const Text('پیگیری ثبت‌نام (بدون ورود)'),
        ),
      ]),
    )) :
    SingleChildScrollView(padding:const EdgeInsets.all(16), child:Column(children:[
      Container(width:80, height:80, decoration:const BoxDecoration(
          color:AppColors.primary, shape:BoxShape.circle),
        child:const Icon(Icons.person, size:44, color:Colors.white)),
      const SizedBox(height:12),
      Text(_user!['name']??'', style:const TextStyle(fontSize:18,fontWeight:FontWeight.bold)),
      Text(_user!['role_label']??'', style:TextStyle(fontSize:13,color:Colors.grey.shade600)),
      const SizedBox(height:20),

      Card(child:Padding(padding:const EdgeInsets.all(16), child:Column(children:[
        InfoTile(icon:Icons.badge_outlined, label:'کد ملی', value:_user!['national_id']??'—'),
        InfoTile(icon:Icons.phone_outlined, label:'موبایل', value:_user!['phone']??'—'),
        InfoTile(icon:Icons.email_outlined, label:'ایمیل', value:_user!['email']??'—'),
        if (_user!['student']!=null) ...[
          const Divider(),
          InfoTile(icon:Icons.school_outlined, label:'رشته',
              value: _fieldLabel(_user!['student']['field']??'')),
          InfoTile(icon:Icons.class_outlined, label:'پایه',
              value: _gradeLabel(_user!['student']['grade']??'')),
          InfoTile(icon:Icons.verified_user_outlined, label:'وضعیت تحصیلی',
              value: _statusLabel(_user!['student']['enrollment_status']??'')),
        ],
      ]))),
      const SizedBox(height:12),

      ListTile(
        shape:RoundedRectangleBorder(borderRadius:BorderRadius.circular(12)),
        tileColor:Colors.white,
        leading:const Icon(Icons.track_changes, color:AppColors.accent),
        title:const Text('پیگیری مشاوره'),
        trailing:const Icon(Icons.chevron_right),
        onTap:()=>Navigator.pushNamed(context,'/reg-check'),
      ),
      const SizedBox(height:8),
      ListTile(
        shape:RoundedRectangleBorder(borderRadius:BorderRadius.circular(12)),
        tileColor:Colors.white,
        leading:const Icon(Icons.logout, color:Colors.red),
        title:const Text('خروج از حساب', style:TextStyle(color:Colors.red)),
        onTap:() async {
          final ok = await showDialog<bool>(context:context,
            builder:(_)=>AlertDialog(
              title:const Text('خروج'),
              content:const Text('آیا می‌خواهید از حساب خارج شوید؟'),
              actions:[
                TextButton(onPressed:()=>Navigator.pop(context,false), child:const Text('انصراف')),
                TextButton(onPressed:()=>Navigator.pop(context,true), child:const Text('خروج')),
              ],
            ));
          if (ok==true) _logout();
        },
      ),
    ])),
  );

  String _fieldLabel(String f) {
    const m={'electrical':'برق صنعتی','mechanical':'تاسیسات مکانیکی',
      'instrumentation':'تعمیرکار ابزار دقیق'};
    return m[f]??f;
  }
  String _gradeLabel(String g) => {'10':'دهم','11':'یازدهم','12':'دوازدهم'}[g]??g;
  String _statusLabel(String s) {
    const m={'pending':'در انتظار','accepted':'پذیرفته شده',
      'rejected':'رد شده','waiting':'لیست انتظار'};
    return m[s]??s;
  }
}
