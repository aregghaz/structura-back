import { Injectable, UnauthorizedException } from '@nestjs/common';
import { UsersService } from '../users/users.service';
import { User } from '../migration/user.entry';
import { JwtService } from '@nestjs/jwt';

@Injectable()
export class AuthService {
  constructor(
    private usersService: UsersService,
    private jwtService: JwtService,
  ) {}

  async signIn(email: string, password: string) {
    const user = await this.usersService.signIn(email);
    if (user?.password !== password) {
      throw new UnauthorizedException();
    }
    const payload = { sub: user.id, username: user.name };
    return {
      access_token: await this.jwtService.signAsync(payload),
    };
  }
}
