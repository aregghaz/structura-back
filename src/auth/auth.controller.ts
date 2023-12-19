import {
  Body,
  Controller,
  Get,
  HttpCode,
  HttpStatus,
  Post,
  Request,
  UseGuards,
} from '@nestjs/common';
import { AuthService } from './auth.service';
import { UsersService } from '../users/users.service';
import { AuthGuard } from './auth.guard';

@Controller('auth')
export class AuthController {
  constructor(
    private authService: AuthService,
    private userService: UsersService,
  ) {}

  @HttpCode(HttpStatus.OK)
  @Post('registration')
  createUser(@Body() ReqBody: Record<string, any>) {
    return this.userService.createUser(ReqBody);
  }

  @HttpCode(HttpStatus.OK)
  @Post('login')
  findOne(@Body() signInDto: Record<string, any>) {
    const { email, password } = signInDto;
    return this.authService.signIn(email, password);
  }

  @UseGuards(AuthGuard)
  @Get('profile')
  getProfile(@Request() req) {
    return req.user;
  }
}
