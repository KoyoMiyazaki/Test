# Generated by Django 3.2.6 on 2021-09-06 07:57

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('micropost', '0001_initial'),
    ]

    operations = [
        migrations.AlterField(
            model_name='user',
            name='email',
            field=models.EmailField(max_length=255, verbose_name='email'),
        ),
    ]
