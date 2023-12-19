import { Entity, Column, PrimaryGeneratedColumn } from 'typeorm';

@Entity()
export class User {
  @PrimaryGeneratedColumn()
  id: number;
  @Column({ unique: true })
  email: string;
  @Column()
  name: string;
  @Column()
  surname: string;
  @Column()
  fatherName: string;
  @Column()
  country: string;
  @Column({ nullable: true })
  passport: string;
  @Column()
  password: string;
  @Column({ default: true })
  isActive: boolean;
  @Column({ nullable: true })
  dob: string;
}
