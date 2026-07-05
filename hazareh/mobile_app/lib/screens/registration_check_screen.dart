import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/common.dart';

class RegistrationCheckScreen extends StatefulWidget {
  const RegistrationCheckScreen({super.key});
  @override
  State<RegistrationCheckScreen> createState() => _RegCheckState();
}

class _RegCheckState extends State<RegistrationCheckScreen> {
  final _nid = TextEditingController();
  Map? _result;
  bool _loading = false;
  bool _searched = false;
  String? _error;

  Future<void> _check() async {
    if (_nid.text.length != 10) {
      setState(() => _error = 'کد ملی باید ۱۰ رقم باشد');
      return;
    }
    setState(() { _loading=true; _error=null; _searched=false; });
    try {
      final d = await ApiService.checkRegistrationStatus(_nid.text.trim());
      if (mounted) setState(() {
        _loading=false; _searched=true;
        if (d['success']==true) _result=d['data'];
        else _result=null;
      });
    } catch(_) {
      if (mounted) setState(() { _loading=false;
        _error='خطا در اتصال'; });
    }
  }

  @override
  Widget build(BuildContext context) => Scaffold(
    appBar: AppBar(title:const Text('پیگیری ثبت‌نام')),
    body: SingleChildScrollView(
      padding:const EdgeInsets.all(24),
      child:Column(children:[
        const Icon(Icons.assignment_ind, size:64, color:AppColors.primary),
        const SizedBox(height:16),
        const Text('پیگیری وضعیت پیش‌ثبت‌نام',
            style:TextStyle(fontSize:18,fontWeight:FontWeight.bold,color:AppColors.primary)),
        const SizedBox(height:8),
        Text('کد ملی خود را وارد کنید تا وضعیت پرونده شما نمایش داده شود.',
            textAlign:TextAlign.center,
            style:TextStyle(fontSize:13,color:Colors.grey.shade600)),
        const SizedBox(height:24),

        TextFormField(
          controller:_nid, keyboardType:TextInputType.number,
          maxLength:10, textDirection:TextDirection.ltr,
          decoration:const InputDecoration(labelText:'کد ملی (۱۰ رقم)', counterText:'',
              prefixIcon:Icon(Icons.badge_outlined))),
        if (_error!=null) Padding(
          padding:const EdgeInsets.only(top:6),
          child:Text(_error!, style:const TextStyle(color:Colors.red,fontSize:12))),
        const SizedBox(height:20),
        PrimaryButton(label:'بررسی وضعیت', onPressed:_check, loading:_loading),
        const SizedBox(height:24),

        if (_searched && _result==null)
          Container(padding:const EdgeInsets.all(16),
            decoration:BoxDecoration(color:Colors.orange.shade50,
                borderRadius:BorderRadius.circular(12),
                border:Border.all(color:Colors.orange.shade200)),
            child:const Row(children:[
              Icon(Icons.info_outline,color:Colors.orange),
              SizedBox(width:10),
              Expanded(child:Text('پیش‌ثبت‌نامی با این کد ملی یافت نشد.',
                  style:TextStyle(fontSize:14))),
            ])),

        if (_result!=null) ...[
          Container(padding:const EdgeInsets.all(16),
            decoration:BoxDecoration(
              color:_statusColor(_result!['status']).withOpacity(0.08),
              borderRadius:BorderRadius.circular(12),
              border:Border.all(color:_statusColor(_result!['status']).withOpacity(0.3))),
            child:Column(children:[
              Row(mainAxisAlignment:MainAxisAlignment.spaceBetween,children:[
                const Text('وضعیت ثبت‌نام:',
                    style:TextStyle(fontWeight:FontWeight.bold,fontSize:15)),
                StatusBadge(label:_result!['status_label']??'',
                    color:_statusColor(_result!['status'])),
              ]),
              if (_result!['admin_note']!=null&&_result!['admin_note'].toString().isNotEmpty)...[
                const Divider(height:20),
                Align(alignment:Alignment.centerRight,
                    child:const Text('یادداشت مدیر:',
                        style:TextStyle(fontWeight:FontWeight.w600))),
                const SizedBox(height:4),
                Text(_result!['admin_note'].toString(),
                    style:const TextStyle(fontSize:13,height:1.7)),
              ],
            ])),
        ],
      ]),
    ),
  );

  Color _statusColor(String? s) => switch(s) {
    'accepted' => Colors.green,
    'rejected'  => Colors.red,
    'reviewed'  => Colors.blue,
    _           => Colors.orange,
  };
}
